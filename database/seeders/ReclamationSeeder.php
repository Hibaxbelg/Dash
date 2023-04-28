<?php

namespace Database\Seeders;

use App\Models\Reclamation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReclamationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reclamation::create([
            'cnamId' => '010000847940',
            'user_id' => 1,
            'objet' => 'très long à charger',
            'description' => 'les pages sont très longues à charger et il est difficile de naviguer dans le menu principal',
            'Solution' => 'Formatage pc et l\'ajout d\'une barette mémoire supp',
        ]);
    }
}
