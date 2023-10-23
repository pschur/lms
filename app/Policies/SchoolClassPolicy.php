<?php

namespace App\Policies;

use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Testing\Fluent\Concerns\Has;

class SchoolClassPolicy
{
    use HasFunctionalMethods;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('class.viewAny') && $user->tokenCan('class.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SchoolClass $schoolClass): bool
    {
        $else = $user->can('class.view') && $user->tokenCan('class.view');
        return $this->default($user, $schoolClass, $else);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('class.create') && $user->tokenCan('class.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SchoolClass $schoolClass): bool
    {
        return $this->default($user, $schoolClass, 'class.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SchoolClass $schoolClass): bool
    {
        return $this->default($user, $schoolClass, 'class.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SchoolClass $schoolClass): bool
    {
        return $this->default($user, $schoolClass, 'class.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SchoolClass $schoolClass): bool
    {
        return $this->default($user, $schoolClass, 'class.forceDelete');
    }
}
