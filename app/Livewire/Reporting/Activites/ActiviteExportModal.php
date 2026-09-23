<?php

namespace App\Livewire\Reporting\Activites;

use Livewire\Component;
use App\Models\Activite;
use App\Models\Organisation;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ActiviteExportModal extends Component
{
    public $show = false;
    public $date_debut = '';
    public $date_fin = '';
    public $format = 'excel';
    public $organisation_id = '';

    #[On('open-export-modal')]
    public function openModal()
    {
        $user = Auth::user();
        $this->reset(['date_debut', 'date_fin', 'format']);
        $this->format = 'excel';

        if (!$user->hasRole('Admin')) {
            $this->organisation_id = $user->organisation_id;
        } else {
            $this->organisation_id = '';
        }

        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
    }

    public function export()
    {
        $user = Auth::user();

        $this->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'format' => 'required|in:excel,pdf',
        ]);

        // Forced security rule for non-Admin users (Guest)
        $targetOrgId = $user->hasRole('Admin') ? $this->organisation_id : $user->organisation_id;

        $query = Activite::with(['secteur', 'createur.organisation'])
            ->whereBetween('date_activite', [$this->date_debut, $this->date_fin]);

        if (!empty($targetOrgId)) {
            $query->whereHas('createur', function ($q) use ($targetOrgId) {
                $q->where('organisation_id', $targetOrgId);
            });
        }

        $activites = $query->orderBy('date_activite', 'desc')->get();

        if ($this->format === 'pdf') {
            return $this->exportPdf($activites, $targetOrgId);
        }

        return $this->exportExcel($activites);
    }

    private function exportPdf($activites, $targetOrgId)
    {
        $user = Auth::user();

        $organisationName = 'Toutes les organisations';
        if (!empty($targetOrgId)) {
            $org = Organisation::find($targetOrgId);
            if ($org) {
                $organisationName = $org->denomination;
            }
        }

        // Group activities by sector denomination
        $groupedActivites = $activites->groupBy(function ($act) {
            return optional($act->secteur)->denomination ?? 'Secteur Non Spécifié';
        });

        $pdf = Pdf::loadView('reports.pdf-activities', [
            'groupedActivites' => $groupedActivites,
            'dateDebut' => date('d/m/Y', strtotime($this->date_debut)),
            'dateFin' => date('d/m/Y', strtotime($this->date_fin)),
            'organisationName' => $organisationName,
            'exporterName' => $user->nom,
            'exportDate' => now()->format('d/m/Y H:i'),
            'totalActivites' => $activites->count(),
            'totalPersonnes' => $activites->sum('nbre_personnes'),
            'totalMenages' => $activites->sum('nbre_menage'),
        ]);

        $pdf->setPaper('A4', 'portrait');

        $fileName = 'Rapport_Activites_' . date('Ymd_His') . '.pdf';
        $this->close();

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $fileName, ['Content-Type' => 'application/pdf']);
    }

    private function exportExcel($activites)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Activités');

        // En-tête des colonnes
        $headers = [
            'A1' => 'Intitulé',
            'B1' => 'Secteur',
            'C1' => 'Date Activité',
            'D1' => 'Organisation',
            'E1' => 'Localités',
            'F1' => 'Personnes Touchées',
            'G1' => 'Ménages Touchés',
            'H1' => 'Statut',
            'I1' => 'Description',
            'J1' => 'Défis & Contraintes',
        ];

        foreach ($headers as $cell => $text) {
            $sheet->setCellValue($cell, $text);
        }

        // Style de l'en-tête
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0072BC'],
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);

        $row = 2;
        foreach ($activites as $act) {
            $sheet->setCellValue("A{$row}", $act->intitule);
            $sheet->setCellValue("B{$row}", optional($act->secteur)->denomination ?? 'N/A');
            $sheet->setCellValue("C{$row}", $act->date_activite ? $act->date_activite->format('d/m/Y') : '');
            $sheet->setCellValue("D{$row}", optional(optional($act->createur)->organisation)->denomination ?? 'N/A');
            $sheet->setCellValue("E{$row}", $act->localites ?? 'N/A');
            $sheet->setCellValue("F{$row}", $act->nbre_personnes ?? 0);
            $sheet->setCellValue("G{$row}", $act->nbre_menage ?? 0);
            $sheet->setCellValue("H{$row}", ucfirst($act->statut));
            $sheet->setCellValue("I{$row}", $act->description ?? '');
            $sheet->setCellValue("J{$row}", $act->defis_contraintes ?? '');
            $row++;
        }

        // Ajuster largeur auto des colonnes
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $fileName = 'Export_Activites_' . date('Ymd_His') . '.xlsx';
        $this->close();

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    public function render()
    {
        return view('livewire.reporting.activites.activite-export-modal', [
            'organisations' => Organisation::orderBy('denomination')->get(),
        ]);
    }
}
