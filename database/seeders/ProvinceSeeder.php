<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            ['id' => 'NK', 'nom_province' => 'Nord-Kivu'],
            ['id' => 'SK', 'nom_province' => 'Sud-Kivu'],
            ['id' => 'IT', 'nom_province' => 'Ituri'],
            ['id' => 'TA', 'nom_province' => 'Tanganyika'],
            ['id' => 'KIN', 'nom_province' => 'Kinshasa'],
            ['id' => 'KAS', 'nom_province' => 'Kasaï'],
            ['id' => 'KAC', 'nom_province' => 'Kasaï-Central'],
            ['id' => 'KAO', 'nom_province' => 'Kasaï-Oriental'],
            ['id' => 'MAN', 'nom_province' => 'Maniema'],
            ['id' => 'HU', 'nom_province' => 'Haut-Uélé'],
        ];

        foreach ($provinces as $province) {
            \App\Models\Province::updateOrCreate(
                ['id' => $province['id']],
                ['nom_province' => $province['nom_province']]
            );
        }
    }
}
