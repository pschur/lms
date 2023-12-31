<?php

namespace App\Policies;

use App\Models\School;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

class SchoolPolicy
{
    use HasFunctionalMethods;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('school.viewAny') && $user->tokenCan('school.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, School $school): bool
    {

        return $this->default($user, $school, 'school.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('school.create') && $user->tokenCan('school.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, School $school): bool
    {
        return $this->default($user, $school, 'school.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, School $school): bool
    {
        return $this->default($user, $school, 'school.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, School $school): bool
    {
        return $this->default($user, $school, 'school.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, School $school): bool
    {
        return $this->default($user, $school, 'choolforceDelete');
    }
}
