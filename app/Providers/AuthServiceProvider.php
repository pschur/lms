<?php

namespace App\Providers;

use App\Models\{School, SchoolClass, Subject, User};
use App\Policies\{SchoolClassPolicy, SchoolPolicy, SubjectPolicy};
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        School::class => SchoolPolicy::class,
        SchoolClass::class => SchoolClassPolicy::class,
        Subject::class => SubjectPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::before(function(User $user){
            return $user->hasRole('root') ? true : null;
        });

        Gate::define('root', function(User $user){
            return $user->hasRole('root');
        });
    }
}
