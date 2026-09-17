<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Activite;
use App\Models\User;
use App\Models\Organisation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardStats extends Component
{
    public function render()
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('Admin');

        $activitesQuery = Activite::query();
        if (!$isAdmin) {
            $activitesQuery->whereHas('createur', function($q) use ($user) {
                $q->where('organisation_id', $user->organisation_id);
            });
        }

        $totalActivites = (clone $activitesQuery)->count();
        $activitesEnCours = (clone $activitesQuery)->where('statut', 'en cours')->count();
        $activitesCloturees = (clone $activitesQuery)->where('statut', 'clôturée')->count();
        
        $totalPersonnes = (clone $activitesQuery)->sum('nbre_personnes');
        
        $totalUsers = $isAdmin ? User::count() : User::where('organisation_id', $user->organisation_id)->count();
        $totalOrgs = $isAdmin ? Organisation::count() : 1;

        $activitesParSecteur = (clone $activitesQuery)
            ->select('secteur_id', DB::raw('count(*) as total'))
            ->groupBy('secteur_id')
            ->with('secteur')
            ->get()
            ->mapWithKeys(function ($item) {
                return [optional($item->secteur)->denomination ?? 'N/A' => $item->total];
            })
            ->toArray();

        return view('livewire.dashboard.dashboard-stats', [
            'totalActivites' => $totalActivites,
            'activitesEnCours' => $activitesEnCours,
            'activitesCloturees' => $activitesCloturees,
            'totalPersonnes' => $totalPersonnes,
            'totalUsers' => $totalUsers,
            'totalOrgs' => $totalOrgs,
            'activitesParSecteurLabels' => json_encode(array_keys($activitesParSecteur)),
            'activitesParSecteurData' => json_encode(array_values($activitesParSecteur)),
            'isAdmin' => $isAdmin,
        ]);
    }
}
