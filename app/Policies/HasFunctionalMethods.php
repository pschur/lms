<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

trait HasFunctionalMethods
{
    public function before(User $user){
        if (Gate::forUser($user)->allows('root')){
            return true;
        }
    }

    public function default(User $user, Model $model, bool|string $default = false): bool
    {
        if ($user->id == $model->owner_id){
            return true;
        }

        if (is_string($default)){
            if (Gate::has($default)){
                return Gate::check($default);
            }

            return $user->can($default) && $user->tokenCan($default);
        }

        return $default;
    }
}
