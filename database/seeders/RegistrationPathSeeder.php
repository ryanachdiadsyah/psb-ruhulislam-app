<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RegistrationPath;

class RegistrationPathSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RegistrationPath::updateOrCreate(
            ['code' => 'INVITATION'],
            [
                'name' => 'Jalur Undangan',
                'requires_invite_code' => true,
                'is_free' => true,
                'is_active' => true,
            ]
        );

        RegistrationPath::updateOrCreate(
            ['code' => 'REGULAR'],
            [
                'name' => 'Jalur Reguler',
                'requires_invite_code' => false,
                'is_free' => false,
                'is_active' => true,
            ]
        );
    }
}
