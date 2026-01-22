<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PsbConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configs = [

            // Invitation Schedule
            [
                'key' => 'invitation_registration_start',
                'value' => '2026-01-01 00:00:00',
                'label' => 'Buka Pendaftaran Jalur Undangan',
                'group' => 'schedule',
                'type' => 'datetime',
            ],
            [
                'key' => 'invitation_registration_end',
                'value' => '2026-01-05 23:59:59',
                'label' => 'Tutup Pendaftaran Jalur Undangan',
                'group' => 'schedule',
                'type' => 'datetime',
            ],
            [
                'key' => 'invitation_administration_verification_start',
                'value' => '2026-01-06 00:00:00',
                'label' => 'Buka Verifikasi Berkas Jalur Undangan',
                'group' => 'schedule',
                'type' => 'datetime',
            ],
            [
                'key' => 'invitation_administration_verification_end',
                'value' => '2026-01-09 23:59:59',
                'label' => 'Tutup Verifikasi Berkas Jalur Undangan',
                'group' => 'schedule',
                'type' => 'datetime',
            ],
            [
                'key' => 'invitation_administration_announcement',
                'value' => '2026-01-10 00:00:00',
                'label' => 'Pengumuman Verifikasi Berkas Jalur Undangan',
                'group' => 'schedule',
                'type' => 'datetime',
            ],
            [
                'key' => 'invitation_exam_start',
                'value' => '2026-01-11 00:00:00',
                'label' => 'Mulai Wawancara Jalur Undangan',
                'group' => 'schedule',
                'type' => 'datetime',
            ],
            [
                'key' => 'invitation_exam_end',
                'value' => '2026-01-11 00:00:00',
                'label' => 'Selesai Wawancara Jalur Undangan',
                'group' => 'schedule',
                'type' => 'datetime',
            ],
            [
                'key' => 'invitation_exam_announcement',
                'value' => '2026-01-12 23:59:59',
                'label' => 'Pengumuman Kelulusan Jalur Undangan',
                'group' => 'schedule',
                'type' => 'datetime',
            ],
            [
                'key' => 'invitation_reregistration_start',
                'value' => '2026-01-13 00:00:00',
                'label' => 'Mulai Daftar Ulang Jalur Undangan',
                'group' => 'schedule',
                'type' => 'datetime',
            ],
            [
                'key' => 'invitation_reregistration_end',
                'value' => '2026-01-23 00:00:00',
                'label' => 'Selesai Daftar Ulang Jalur Undangan',
                'group' => 'schedule',
                'type' => 'datetime',
            ],

            // Regular Schedule
            [
                'key' => 'regular_registration_start',
                'value' => '2026-02-01 00:00:00',
                'label' => 'Buka Pendaftaran Jalur Reguler',
                'group' => 'schedule',
                'type' => 'datetime',
            ],
            [
                'key' => 'regular_registration_end',
                'value' => '2026-02-05 23:59:59',
                'label' => 'Tutup Pendaftaran Jalur Reguler',
                'group' => 'schedule',
                'type' => 'datetime',
            ],
            [
                'key' => 'regular_administration_verification_start',
                'value' => '2026-02-06 00:00:00',
                'label' => 'Buka Verifikasi Berkas Jalur Reguler',
                'group' => 'schedule',
                'type' => 'datetime',
            ],
            [
                'key' => 'regular_administration_verification_end',
                'value' => '2026-02-09 23:59:59',
                'label' => 'Tutup Verifikasi Berkas Jalur Reguler',
                'group' => 'schedule',
                'type' => 'datetime',
            ],
            [
                'key' => 'regular_exam_start',
                'value' => '2026-02-11 00:00:00',
                'label' => 'Mulai Ujian Seleksi Masuk Jalur Reguler',
                'group' => 'schedule',
                'type' => 'datetime',
            ],
            [
                'key' => 'regular_exam_end',
                'value' => '2026-02-13 00:00:00',
                'label' => 'Selesai Ujian Seleksi Masuk Jalur Reguler',
                'group' => 'schedule',
                'type' => 'datetime',
            ],
            [
                'key' => 'regular_exam_announcement',
                'value' => '2026-02-15 23:59:59',
                'label' => 'Pengumuman Kelulusan Jalur Reguler',
                'group' => 'schedule',
                'type' => 'datetime',
            ],
            [
                'key' => 'regular_reregistration_start',
                'value' => '2026-02-16 00:00:00',
                'label' => 'Mulai Daftar Ulang Jalur Reguler',
                'group' => 'schedule',
                'type' => 'datetime',
            ],
            [
                'key' => 'regular_reregistration_end',
                'value' => '2026-02-28 00:00:00',
                'label' => 'Selesai Daftar Ulang Jalur Reguler',
                'group' => 'schedule',
                'type' => 'datetime',
            ],
            

            /*
            |--------------------------------------------------------------------------
            | INVITATION CONFIG
            |--------------------------------------------------------------------------
            */
            [
                'key' => 'invitation_code',
                'value' => 'UNDANGAN2026',
                'label' => 'Kode Undangan',
                'group' => 'invitation',
                'type' => 'text',
            ],

            /*
            |--------------------------------------------------------------------------
            | PAYMENT CONFIG (LEGACY – BIARKAN DULU)
            |--------------------------------------------------------------------------
            */
            [
                'key' => 'registration_bank_account_number',
                'value' => '1234567890',
                'label' => 'Nomor Rekening Bank Pendaftaran',
                'group' => 'payment',
                'type' => 'number',
            ],
            [
                'key' => 'registration_bank_account_name',
                'value' => 'PSB Ruhul Islam Anak Bangsa',
                'label' => 'Nama Pemilik Rekening Bank Pendaftaran',
                'group' => 'payment',
                'type' => 'text',
            ],
            [
                'key' => 'registration_bank_name',
                'value' => 'Bank Aceh Syariah',
                'label' => 'Nama Bank Pendaftaran',
                'group' => 'payment',
                'type' => 'text',
            ],
            [
                'key' => 're_registration_bank_account_number',
                'value' => '1234567890',
                'label' => 'Nomor Rekening Bank Pendaftaran Ulang',
                'group' => 'payment',
                'type' => 'number',
            ],
            [
                'key' => 're_registration_bank_account_name',
                'value' => 'PSB Ruhul Islam Anak Bangsa',
                'label' => 'Nama Pemilik Rekening Bank Pendaftaran Ulang',
                'group' => 'payment',
                'type' => 'text',
            ],
            [
                'key' => 're_registration_bank_name',
                'value' => 'Bank Aceh Syariah',
                'label' => 'Nama Bank Pendaftaran Ulang',
                'group' => 'payment',
                'type' => 'text',
            ],

            /*
            |--------------------------------------------------------------------------
            | LEGACY / UNKNOWN (DARI SQL LAMA)
            |--------------------------------------------------------------------------
            */
            [
                'key' => 'school_year',
                'value' => '2026',
                'group' => 'legacy',
                'type' => 'text',
            ],
            [
                'key' => 'psb_head_commitee_name',
                'value' => 'Ryan Achdiadsyah',
                'group' => 'legacy',
                'type' => 'text',
            ],
            [
                'key' => 'psb_head_commitee_signature',
                'value' => '#',
                'group' => 'legacy',
                'type' => 'file',
            ],
            [
                'key' => 'brochure_file',
                'value' => '#',
                'group' => 'legacy',
                'type' => 'file',
            ],
            [
                'key' => 'booklet_file',
                'value' => '#',
                'group' => 'legacy',
                'type' => 'file',
            ],

            // Prefix and Suffix for Room Configuration
            [
                'key' => 'session_a_day',
                'value' => '3',
                'group' => 'room_configuration',
                'type' => 'number',
            ],
            // CAT Room Configuration
            [
                'key' => 'cat_room_total',
                'value' => '3',
                'group' => 'room_configuration',
                'type' => 'number',
            ],
            [
                'key' => 'cat_room_prefix',
                'value' => 'Ruang Lab-',
                'group' => 'room_configuration',
                'type' => 'text',
            ],
            [
                'key' => 'cat_room_max_capacity',
                'value' => '33',
                'group' => 'room_configuration',
                'type' => 'number',
            ],
            // Interview Room Configuration
            [
                'key' => 'interview_room_total',
                'value' => '11',
                'group' => 'room_configuration',
                'type' => 'number',
            ],
            [
                'key' => 'interview_room_prefix',
                'value' => 'Ruang Kelas-',
                'group' => 'room_configuration',
                'type' => 'text',
            ],
            [
                'key' => 'interview_room_max_capacity',
                'value' => '9',
                'group' => 'room_configuration',
                'type' => 'number',
            ],
            // Parent Interview Room Configuration
            [
                'key' => 'parent_interview_room_total',
                'value' => '3',
                'group' => 'room_configuration',
                'type' => 'number',
            ],
            [
                'key' => 'parent_interview_room_prefix',
                'value' => 'Ruang Wali-',
                'group' => 'room_configuration',
                'type' => 'text',
            ],
            [
                'key' => 'parent_interview_room_max_capacity',
                'value' => '33',
                'group' => 'room_configuration',
                'type' => 'number',
            ],


        ];

        foreach ($configs as $config) {
            DB::table('psb_configs')->updateOrInsert(
                ['key' => $config['key']],
                [
                    'value' => $config['value'],
                    'group' => $config['group'],
                    'type' => $config['type'],
                    'is_active' => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
