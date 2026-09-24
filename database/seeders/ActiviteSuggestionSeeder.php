<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ActiviteSuggestion;

class ActiviteSuggestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = base_path('docs/Activités_Humanitaires_Secteurs.csv');

        if (!file_exists($csvPath)) {
            return;
        }

        if (($handle = fopen($csvPath, 'r')) !== false) {
            // Remove UTF-8 BOM if present
            $bom = fread($handle, 3);
            if ($bom !== "\xEF\xBB\xBF") {
                rewind($handle);
            }

            // Skip header row
            fgetcsv($handle, 1000, ',');

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if (count($data) >= 2) {
                    $secteur = trim($data[0]);
                    $activite = trim($data[1]);

                    if ($secteur !== '' && $activite !== '') {
                        ActiviteSuggestion::firstOrCreate([
                            'secteur' => $secteur,
                            'activite' => $activite,
                        ]);
                    }
                }
            }
            fclose($handle);
        }
    }
}
