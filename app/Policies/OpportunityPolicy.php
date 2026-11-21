<?php

namespace App\Policies;

use App\Models\Opportunity;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OpportunityPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Opportunity $o): bool
    {
        if ($user->hasAccess('platform.opportunities') || $this->owns($user, $o)) {
            return true;
        }

        // Anggota lain hanya boleh melihat yang terbit dan belum kedaluwarsa
        return $user->hasAccess('platform.opportunity-board')
            && $o->status === Opportunity::PUBLISHED
            && ! $o->isExpired();
    }

    public function update(User $user, Opportunity $o): bool
    {
        return $user->hasAccess('platform.opportunities') || $this->owns($user, $o);
    }

    public function delete(User $user, Opportunity $o): bool
    {
        return $user->hasAccess('platform.opportunities');
    }

    private function owns(User $user, Opportunity $o): bool
    {
        $memberId = $user->member?->id;

        return $memberId !== null && (int) $o->member_id === (int) $memberId;
    }
}
