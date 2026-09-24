<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Secteur;
use App\Models\ActiviteSuggestion;
use App\Livewire\Reporting\Activites\ActiviteFormModal;
use Database\Seeders\SecteurSeeder;
use Database\Seeders\ActiviteSuggestionSeeder;
use Livewire\Livewire;

class ActiviteSuggestionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SecteurSeeder::class);
        $this->seed(ActiviteSuggestionSeeder::class);
    }

    public function test_seeder_populates_activite_suggestions()
    {
        $this->assertDatabaseCount('activite_suggestions', 70);
        $this->assertDatabaseHas('activite_suggestions', [
            'secteur' => 'WASH',
            'activite' => 'Construction de forages d\'eau',
        ]);
    }

    public function test_activite_form_modal_returns_suggestions()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(ActiviteFormModal::class)
            ->set('intitule', 'forages')
            ->assertViewHas('suggestions', function ($suggestions) {
                return $suggestions->contains('activite', 'Construction de forages d\'eau');
            });
    }

    public function test_selecting_suggestion_sets_intitule_and_matching_secteur()
    {
        $user = User::factory()->create();
        $suggestion = ActiviteSuggestion::where('activite', 'Construction de forages d\'eau')->first();

        Livewire::actingAs($user)
            ->test(ActiviteFormModal::class)
            ->call('selectSuggestion', $suggestion->id)
            ->assertSet('intitule', 'Construction de forages d\'eau')
            ->assertSet('secteur_id', function ($secteurId) {
                $washSecteur = Secteur::where('denomination', 'WASH')->first();
                return $secteurId === $washSecteur->id;
            });
    }

    public function test_selecting_secteur_filters_suggestions_for_that_secteur()
    {
        $user = User::factory()->create();
        $washSecteur = Secteur::where('denomination', 'WASH')->first();

        Livewire::actingAs($user)
            ->test(ActiviteFormModal::class)
            ->set('secteur_id', $washSecteur->id)
            ->assertViewHas('selectedSecteurName', 'WASH')
            ->assertViewHas('suggestions', function ($suggestions) {
                return $suggestions->every(fn($s) => $s->secteur === 'WASH');
            });
    }
}
