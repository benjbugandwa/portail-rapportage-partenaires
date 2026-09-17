<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Secteur;

class SecteurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $secteurs = [
            'Violences Basées sur le Genre',
            'Protection',
            'WASH',
            'Abris',
            'Nutrition',
            'Santé',
            'Education',
            'Cash',
            'Sécurité Alimentaire',
            'Protection de l\'enfant',
            'Enregistrement et Documentation',
            'moyens de subsistance'
        ];

        foreach ($secteurs as $secteur) {
            Secteur::firstOrCreate([
                'denomination' => $secteur,
            ]);
        }
    }
}
