<?php

namespace App\Livewire\Reporting\Activites;

use Livewire\Component;
use App\Models\Activite;
use Illuminate\Support\Facades\Response;
use Livewire\Attributes\On;

class ActiviteExportModal extends Component
{
    public $show = false;
    public $date_debut = '';
    public $date_fin = '';

    #[On('open-export-modal')]
    public function openModal()
    {
        $this->reset(['date_debut', 'date_fin']);
        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
    }

    public function export()
    {
        $this->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        $activites = Activite::with(['secteur', 'createur.organisation'])
            ->whereBetween('date_activite', [$this->date_debut, $this->date_fin])
            ->get();

        $csvData = "Intitule;Secteur;Date;Organisation;Statut\n";

        foreach ($activites as $activite) {
            $org = optional(optional($activite->createur)->organisation)->denomination ?? 'N/A';
            $secteur = optional($activite->secteur)->denomination ?? 'N/A';
            
            $csvData .= sprintf(
                "%s;%s;%s;%s;%s\n",
                $this->escapeCsv($activite->intitule),
                $this->escapeCsv($secteur),
                $activite->date_activite->format('Y-m-d'),
                $this->escapeCsv($org),
                $this->escapeCsv($activite->statut)
            );
        }

        $fileName = 'export_activites_' . date('Y-m-d_H-i-s') . '.csv';
        
        $this->close();
        
        return response()->streamDownload(function () use ($csvData) {
            echo "\xEF\xBB\xBF";
            echo $csvData;
        }, $fileName, ['Content-Type' => 'text/csv']);
    }

    private function escapeCsv($value)
    {
        if (str_contains((string)$value, ';') || str_contains((string)$value, '"') || str_contains((string)$value, "\n")) {
            $value = str_replace('"', '""', $value);
            return '"' . $value . '"';
        }
        return $value;
    }

    public function render()
    {
        return view('livewire.reporting.activites.activite-export-modal');
    }
}
