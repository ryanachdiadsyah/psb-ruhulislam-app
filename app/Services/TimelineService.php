<?php
namespace App\Services;
use App\Models\User;
use Illuminate\Support\Carbon;

class TimelineService
{
    public static function forUser(User $user): array
    {
        $path = $user->onboarding->initialPath->code;

        return match ($path) {
            'INVITATION' => self::invitation(),
            'REGULAR'    => self::regular(),
            default      => [],
        };
    }

    /* ======================================================
    | INVITATION TIMELINE
    ====================================================== */
    private static function invitation(): array
    {
        return self::build([
            [
                'key'           => 'invitation_registration',
                'label'         => 'Pendaftaran Jalur Undangan',
                'start'         => 'invitation_registration_start',
                'end'           => 'invitation_registration_end',
                'description'   => 'Calon peserta didik baru melakukan pendaftaran secara online melalui aplikasi PSB Ruhul Islam.',
            ],
            [
                'key'           => 'invitation_administration_verification',
                'label'         => 'Verifikasi Berkas',
                'start'         => 'invitation_administration_verification_start',
                'end'           => 'invitation_administration_verification_end',
                'description'   => 'Panitia PSB Ruhul Islam melakukan verifikasi berkas pendaftaran yang telah diunggah oleh calon peserta didik baru. Pastikan semua berkas telah diunggah dengan benar sebelum tanggal berakhir verifikasi berkas.',
            ],
            [
                'key'           => 'invitation_administration_verification_announcement',
                'label'         => 'Pengumuman Verifikasi Berkas',
                'start'         => 'invitation_administration_announcement',
                'end'           => 'invitation_administration_announcement',
                'description'   => 'Pengumuman hasil verifikasi berkas pendaftaran akan diumumkan pada tanggal yang telah ditetapkan. Pastikan untuk memeriksa pengumuman secara berkala. Peserta yang lulus verifikasi berkas dapat melanjutkan ke tahap wawancara. Jika tidak lulus, peserta dapat berpindah ke jalur reguler untuk melanjutkan seleksi.',
            ],
            [
                'key'           => 'invitation_interview',
                'label'         => 'Wawancara / Interview',
                'start'         => 'invitation_exam_start',
                'end'           => 'invitation_exam_end',
                'description'   => 'Calon peserta didik baru mengikuti wawancara sesuai jadwal yang telah ditentukan. Persiapkan diri Anda dengan baik untuk menghadapi wawancara.',
            ],
            [
                'key'           => 'invitation_exam_announcement',
                'label'         => 'Pengumuman Kelulusan',
                'start'         => 'invitation_exam_announcement',
                'end'           => 'invitation_exam_announcement',
                'description'   => 'Pengumuman hasil wawancara akan diumumkan pada tanggal yang telah ditetapkan. Pastikan untuk memeriksa pengumuman secara berkala.',
            ],
            [
                'key'           => 'invitation_re_registration',
                'label'         => 'Daftar Ulang',
                'start'         => 'invitation_reregistration_start',
                'end'           => 'invitation_reregistration_end',
                'description'   => 'Calon peserta didik baru yang dinyatakan lulus wajib melakukan daftar ulang sesuai jadwal yang telah ditentukan serta membayar seluruh biaya pendaftaran ulang.',
            ],
        ]);
    }

    /* ======================================================
    | REGULAR TIMELINE
    ====================================================== */
    private static function regular(): array
    {
        return self::build([
            [
                'key'           => 'regular_registration',
                'label'         => 'Pendaftaran Jalur Reguler',
                'start'         => 'regular_registration_start',
                'end'           => 'regular_registration_end',
                'description'   => 'Calon peserta didik baru melakukan pendaftaran secara online melalui aplikasi PSB Ruhul Islam.',
            ],
            [
                'key'           => 'regular_administration_verification',
                'label'         => 'Verifikasi Berkas',
                'start'         => 'regular_administration_verification_start',
                'end'           => 'regular_administration_verification_end',
                'description'   => 'Panitia PSB Ruhul Islam melakukan verifikasi berkas pendaftaran yang telah diunggah oleh calon peserta didik baru. Pastikan semua berkas telah diunggah dengan benar sebelum tanggal berakhir verifikasi berkas.',
            ],
            [
                'key'           => 'regular_exam',
                'label'         => 'Ujian Seleksi Masuk',
                'start'         => 'regular_exam_start',
                'end'           => 'regular_exam_end',
                'description'   => 'Calon peserta didik baru mengikuti ujian seleksi masuk sesuai jadwal yang telah ditentukan. Persiapkan diri Anda dengan baik untuk menghadapi ujian.',
            ],
            [
                'key'           => 'regular_exam_announcement',
                'label'         => 'Pengumuman Kelulusan',
                'start'         => 'regular_exam_announcement',
                'end'           => 'regular_exam_announcement',
                'description'   => 'Pengumuman hasil ujian seleksi masuk akan diumumkan pada tanggal yang telah ditetapkan. Pastikan untuk memeriksa pengumuman secara berkala.',
            ],
            [
                'key'           => 'regular_re_registration',
                'label'         => 'Daftar Ulang',
                'start'         => 'regular_reregistration_start',
                'end'           => 'regular_reregistration_start',
                'description'   => 'Calon peserta didik baru yang dinyatakan lulus wajib melakukan daftar ulang sesuai jadwal yang telah ditentukan serta membayar seluruh biaya pendaftaran ulang.',
            ],
        ]);
    }

    /* ======================================================
    | CORE BUILDER
    ====================================================== */
    private static function build(array $items): array
    {
        return collect($items)->map(function ($item) {

            $start = self::configDate($item['start']);
            $end   = self::configDate($item['end']);

            return [
                'key'           => $item['key'],
                'label'         => $item['label'],
                'start_at'      => $start,
                'end_at'        => $end,
                'description'   => $item['description'] ?? null,
                'status'        => self::status($start, $end),
            ];
        })->toArray();
    }

    /* ======================================================
    | STATUS ENGINE
    ====================================================== */
    private static function status(?Carbon $start, ?Carbon $end): string
    {
        if (! $start || ! $end) {
            return 'skipped'; // config belum ada
        }

        $now = now();

        if ($now->lt($start)) {
            return 'upcoming';
        }

        if ($now->between($start, $end)) {
            return 'active';
        }

        return 'past';
    }

    /* ======================================================
    | CONFIG PARSER
    ====================================================== */
    private static function configDate(string $key): ?Carbon
    {
        $value = PsbConfigService::get($key);

        if (! $value) {
            return null;
        }

        return Carbon::parse($value);
    }
}