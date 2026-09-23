<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
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
    public function view(User $user, Document $document): bool
    {
        return (bool) $user->is_active;
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
    public function update(User $user, Document $document): bool
    {
        if (!$user->is_active) {
            return false;
        }

        if ($user->hasRole('Admin')) {
            return true;
        }

        if ($document->uploaded_by === $user->id) {
            return true;
        }

        $uploaderOrgId = optional($document->uploader)->organisation_id;
        return $uploaderOrgId && $uploaderOrgId === $user->organisation_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Document $document): bool
    {
        if (!$user->is_active) {
            return false;
        }

        if ($user->hasRole('Admin')) {
            return true;
        }

        if ($document->uploaded_by === $user->id) {
            return true;
        }

        $uploaderOrgId = optional($document->uploader)->organisation_id;
        return $uploaderOrgId && $uploaderOrgId === $user->organisation_id;
    }
}
