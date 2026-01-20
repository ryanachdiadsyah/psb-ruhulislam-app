<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RegistrationFee;
use App\Models\RegistrationPath;

class RegistrationFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regular = RegistrationPath::where('code', 'REGULAR')->first();

        if (! $regular) {
            return;
        }

        RegistrationFee::updateOrCreate(
            [
                'registration_path_id' => $regular->id,
                'is_active' => true,
            ],
            [
                'amount' => 300000, // harga aktif sekarang
            ]
        );
    }
}
