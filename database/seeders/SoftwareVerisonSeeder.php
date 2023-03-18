<?php

namespace Database\Seeders;

use App\Models\SoftwareVersion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SoftwareVerisonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SoftwareVersion::create([
            'name' => 'Medwin Monoposte',
            'min_pc_number' => 1,
            'price' => 300,
            'price_per_additional_pc' => 200
        ]);

        SoftwareVersion::create([
            'name' => 'Medwin Reséaux',
            'min_pc_number' => 1,
            'price' => 500,
            'price_per_additional_pc' => 200
        ]);

        SoftwareVersion::create([
            'name' => 'Medwin Radio',
            'min_pc_number' => 2,
            'price' => 600,
            'price_per_additional_pc' => 200
        ]);

        SoftwareVersion::create([
            'name' => 'Medwin Ophta',
            'min_pc_number' => 2,
            'price' => 600,
            'price_per_additional_pc' => 200
        ]);
    }
}
