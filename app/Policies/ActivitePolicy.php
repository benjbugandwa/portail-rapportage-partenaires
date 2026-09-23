<?php

namespace App\Policies;

use App\Models\Activite;
use App\Models\User;

class ActivitePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return (bool) $user->is_active;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Activite $activite): bool
    {
        if (!$user->is_active) {
            return false;
        }

        if ($user->hasRole('Admin')) {
            return true;
        }

        $creatorOrgId = optional($activite->createur)->organisation_id;
        return $creatorOrgId && $creatorOrgId === $user->organisation_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return (bool) $user->is_active;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Activite $activite): bool
    {
        if (!$user->is_active) {
            return false;
        }

        if ($user->hasRole('Admin')) {
            return true;
        }

        if ($activite->created_by === $user->id) {
            return true;
        }

        $creatorOrgId = optional($activite->createur)->organisation_id;
        return $creatorOrgId && $creatorOrgId === $user->organisation_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Activite $activite): bool
    {
        if (!$user->is_active) {
            return false;
        }

        if ($user->hasRole('Admin')) {
            return true;
        }

        if ($activite->created_by === $user->id) {
            return true;
        }

        $creatorOrgId = optional($activite->createur)->organisation_id;
        return $creatorOrgId && $creatorOrgId === $user->organisation_id;
    }

    /**
     * Determine whether the user can export activities.
     */
    public function export(User $user): bool
    {
        return (bool) $user->is_active;
    }
}
