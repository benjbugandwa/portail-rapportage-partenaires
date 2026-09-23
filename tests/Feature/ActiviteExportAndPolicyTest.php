<?php

namespace Tests\Feature;

use App\Models\Activite;
use App\Models\Organisation;
use App\Models\Secteur;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use App\Livewire\Reporting\Activites\ActiviteExportModal;

class ActiviteExportAndPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Guest', 'guard_name' => 'web']);
    }

    public function test_guest_user_export_modal_restricts_organisation_id_to_own_organisation(): void
    {
        $org1 = Organisation::create(['denomination' => 'Org Alpha']);
        $org2 = Organisation::create(['denomination' => 'Org Beta']);

        $guestUser = User::factory()->create([
            'is_active' => true,
            'organisation_id' => $org1->id,
        ]);
        $guestUser->assignRole('Guest');

        $this->actingAs($guestUser);

        Livewire::test(ActiviteExportModal::class)
            ->call('openModal')
            ->assertSet('organisation_id', $org1->id);
    }

    public function test_admin_user_can_leave_organisation_id_empty_for_all(): void
    {
        $adminUser = User::factory()->create([
            'is_active' => true,
        ]);
        $adminUser->assignRole('Admin');

        $this->actingAs($adminUser);

        Livewire::test(ActiviteExportModal::class)
            ->call('openModal')
            ->assertSet('organisation_id', '');
    }

    public function test_activite_policy_update_permissions(): void
    {
        $org1 = Organisation::create(['denomination' => 'Org Alpha']);
        $org2 = Organisation::create(['denomination' => 'Org Beta']);

        $secteur = Secteur::create(['denomination' => 'Protection', 'description' => 'Secteur protection']);

        $user1 = User::factory()->create(['is_active' => true, 'organisation_id' => $org1->id]);
        $user1->assignRole('Guest');

        $user2 = User::factory()->create(['is_active' => true, 'organisation_id' => $org2->id]);
        $user2->assignRole('Guest');

        $activite = Activite::create([
            'intitule' => 'Distribution vivres',
            'date_activite' => now()->format('Y-m-d'),
            'secteur_id' => $secteur->id,
            'created_by' => $user1->id,
            'statut' => 'en cours',
        ]);

        $this->assertTrue($user1->can('update', $activite));
        $this->assertFalse($user2->can('update', $activite));
    }
}
