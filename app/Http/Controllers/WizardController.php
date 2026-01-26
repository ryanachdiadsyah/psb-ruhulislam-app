<?php

namespace App\Http\Controllers;

use App\Models\InformationSource;
use App\Models\RegistrationFee;
use App\Models\RegistrationOverride;
use App\Models\RegistrationPath;
use App\Models\UserOnboarding;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\PsbConfigService;

class WizardController extends Controller
{
    public function start(Request $request)
    {
        $user = $request->user();

        if ($user->onboarding?->completed_at) {
            return redirect()->route('dashboard');
        }

        $scheduleStatus = [
            'INVITATION' => $this->inSchedule('INVITATION'),
            'REGULAR'    => $this->inSchedule('REGULAR'),
        ];

        return view('app.wizard.step1', [
            'paths'  => RegistrationPath::where('is_active', true)->get(),
            'scheduleStatus' => $scheduleStatus,
        ]);
    }

    public function step2View(Request $request)
    {
        $user = $request->user();

        if (! $user->onboarding || $user->onboarding->completed_at) {
            return redirect()->route('wizard.start');
        }

        return view('app.wizard.step2', [
            'sources' => InformationSource::where('is_active', true)->get(),
        ]);
    }

    private function inSchedule(string $pathCode): bool
    {
        $now = now();

        return match ($pathCode) {
            'INVITATION' => $now->between(
                PsbConfigService::get('invitation_registration_start'),
                PsbConfigService::get('invitation_registration_end')
            ),
            'REGULAR' => $now->between(
                PsbConfigService::get('regular_registration_start'),
                PsbConfigService::get('regular_registration_end')
            ),
            default => false,
        };
    }

    public function step1(Request $request)
    {
        $data = $request->validate([
            'path_code'     => ['required', 'in:INVITATION,REGULAR'],
            'invite_code'   => ['required_if:path_code,INVITATION'],
            'override_code' => ['nullable', 'string'],
        ]);

        $user = $request->user();

        if ($user->onboarding?->completed_at) {
            return redirect()->route('dashboard');
        }

        $path = RegistrationPath::where('code', $data['path_code'])->firstOrFail();

        DB::beginTransaction();

        try {
            $override = null;
            $outOfSchedule = ! $this->inSchedule($path->code);

            /** === OVERRIDE === */
            if ($outOfSchedule) {
                if (empty($data['override_code'])) {
                    DB::rollBack();
                    return back()->withErrors([
                        'override_code' => 'Pendaftaran telah ditutup. Masukkan kode izin pendaftaran dari panitia. jika tidak memiliki, silahkan hubungi panitia.',
                    ]);
                }

                $override = RegistrationOverride::where('code', $data['override_code'])
                    ->where('is_active', true)
                    ->whereNull('used_at')
                    ->lockForUpdate()
                    ->first();

                if (! $override) {
                    DB::rollBack();
                    return back()->withErrors([
                        'override_code' => 'Kode izin tidak valid atau sudah digunakan.',
                    ]);
                }

                if ($override->expires_at && now()->greaterThan($override->expires_at)) {
                    DB::rollBack();
                    return back()->withErrors([
                        'override_code' => 'Kode izin sudah kadaluarsa.',
                    ]);
                }

                if ($override->allowed_paths &&
                    ! in_array($path->code, $override->allowed_paths)) {
                    DB::rollBack();
                    return back()->withErrors([
                        'override_code' => 'Kode izin tidak berlaku untuk jalur ini.',
                    ]);
                }
            }

            /** === INVITATION CODE === */
            if ($path->requires_invite_code) {
                $validCode = PsbConfigService::get('invitation_code');

                if ($data['invite_code'] !== $validCode) {
                    DB::rollBack();
                    return back()->withErrors([
                        'invite_code' => 'Kode undangan tidak valid.',
                    ]);
                }
            }

            /** === FEE SNAPSHOT === */
            $fee = 0;
            if (! $path->is_free) {
                $fee = RegistrationFee::where('registration_path_id', $path->id)
                    ->where('is_active', true)
                    ->value('amount');

                if ($fee === null) {
                    DB::rollBack();
                    abort(500, 'Registration fee not configured');
                }
            }

            /** === SAVE ONBOARDING === */
            UserOnboarding::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'registration_number'          => UserOnboarding::generateRegistrationNumber(),
                    'initial_registration_path_id' => $path->id,
                    'current_registration_path_id' => $path->id,
                    'registration_path_id'         => $path->id, // legacy
                    'invite_code_used'             => $path->requires_invite_code
                        ? ($data['invite_code'] ?? null)
                        : null,
                    'override_code_used'           => $override?->code,
                    'fee_amount'                   => $fee,
                    'payment_status'               => $fee > 0 ? 'UNPAID' : 'EXEMPT',
                ]
            );

            if ($override) {
                $override->update([
                    'used_at'         => now(),
                    'used_by_user_id' => $user->id,
                ]);

                \Log::channel('security')->warning('registration.override_used', [
                    'user_id' => $user->id,
                    'path' => $path->code,
                    'override_code' => $override->code,
                    'ip' => $request->ip(),
                ]);
            }

            if ($outOfSchedule) {
                \Log::channel('security')->info('registration.out_of_schedule', [
                    'user_id' => $user->id,
                    'path' => $path->code,
                    'used_override' => (bool) $override,
                ]);
            }

            DB::commit();
            return redirect()->route('wizard.step2');

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('wizard.start')->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memproses data. Silahkan coba lagi.',
            ]);
        }
    }


    public function step2(Request $request)
    {
        $data = $request->validate([
            'information_source_id' => [
                'required',
                'exists:information_sources,id,is_active,1',
            ],
        ]);

        $user = $request->user();
        $onboarding = $user->onboarding;

        if (! $onboarding || $onboarding->completed_at) {
            return redirect()->route('dashboard');
        }

        $onboarding->update([
            'information_source_id' => $data['information_source_id'],
            'completed_at'          => now(),
        ]);

        app(InvoiceService::class)->createRegistrationInvoice($user);

        return redirect()->route('dashboard');
    }
}
