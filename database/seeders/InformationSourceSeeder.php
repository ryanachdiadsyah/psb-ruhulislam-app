<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InformationSource;

class InformationSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = [
            'WhatsApp',
            'Instagram',
            'Alumni',
            'Sekolah',
            'Brosur',
            'Website',
            'Lainnya',
        ];

        foreach ($sources as $name) {
            InformationSource::updateOrCreate([
                'description' => $name,
            ]);
        }
    }
}
