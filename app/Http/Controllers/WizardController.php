<?php

namespace App\Http\Controllers;

use App\Models\RegistrationFee;
use App\Models\RegistrationOverride;
use App\Models\RegistrationPath;
use App\Models\UserOnboarding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WizardController extends Controller
{
    public function start(Request $request)
    {
        $user = $request->user();

        if ($user->onboarding?->completed_at) {
            return redirect()->route('dashboard');
        }

        return view('wizard.step1', [
            'paths'  => RegistrationPath::where('is_active', true)->get(),
            'config' => config('psb'),
        ]);
    }

    private function inSchedule(string $pathCode): bool
    {
        $now = now();

        return match ($pathCode) {
            'INVITATION' => $now->between(
                config('psb.invitation_start'),
                config('psb.invitation_end')
            ),
            'REGULAR' => $now->between(
                config('psb.regular_start'),
                config('psb.regular_end')
            ),
            default => false,
        };
    }

    public function step1(Request $request)
    {
        $data = $request->validate([
            'path_code'    => ['required', 'in:INVITATION,REGULAR'],
            'invite_code'  => ['nullable', 'string'],
            'override_code'=> ['nullable', 'string'],
        ]);

        $user = $request->user();

        if ($user->onboarding?->completed_at) {
            return redirect()->route('dashboard');
        }

        $path = RegistrationPath::where('code', $data['path_code'])->firstOrFail();
        $override = null;

        /**
         * === OVERRIDE (TERLAMBAT) ===
         */
        if (! $this->inSchedule($path->code)) {

            if (empty($data['override_code'])) {
                return back()->withErrors([
                    'override_code' => 'Pendaftaran telah ditutup. Masukkan kode izin panitia.',
                ]);
            }

            DB::beginTransaction();

            try {
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
            } catch (\Throwable $e) {
                DB::rollBack();
                throw $e;
            }
        }

        /**
         * === INVITATION CODE ===
         */
        if ($path->requires_invite_code) {
            if ($data['invite_code'] !== config('psb.invitation_code')) {
                if ($override) {
                    DB::rollBack();
                }

                return back()->withErrors([
                    'invite_code' => 'Kode undangan tidak valid.',
                ]);
            }
        }

        /**
         * === FEE SNAPSHOT ===
         */
        $fee = 0;

        if (! $path->is_free) {
            $fee = RegistrationFee::where('registration_path_id', $path->id)
                ->where('is_active', true)
                ->value('amount');

            if ($fee === null) {
                if ($override) {
                    DB::rollBack();
                }

                abort(500, 'Registration fee not configured');
            }
        }

        /**
         * === SAVE ONBOARDING ===
         */
        UserOnboarding::updateOrCreate(
            ['user_id' => $user->id],
            [
                'initial_registration_path_id' => $path->id,
                'current_registration_path_id' => $path->id,

                'registration_path_id' => $path->id, // ← boleh dipertahankan atau nanti dihapus
                'invite_code_used'     => $path->requires_invite_code
                    ? ($data['invite_code'] ?? null)
                    : null,
                'override_code_used'   => $override?->code,
                'fee_amount'           => $fee,
            ]
        );

        if ($override) {
            $override->update([
                'used_at'        => now(),
                'used_by_user_id'=> $user->id,
            ]);

            \Log::channel('security')->warning('registration.override_used', [
                'user_id' => $user->id,
                'path' => $path->code,
                'override_code' => $override->code,
                'ip' => $request->ip(),
            ]);

            DB::commit();
        }

        \Log::channel('security')->info('registration.out_of_schedule', [
            'user_id' => $user->id,
            'path' => $path->code,
            'used_override' => (bool) $override,
        ]);

        return redirect()->route('wizard.step2');
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

        return redirect()->route('dashboard');
    }
}
