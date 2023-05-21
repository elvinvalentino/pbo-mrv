<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('root', function (User $user) {
            return $user->role == 'root';
        });
        Gate::define('admin_po', function (User $user) {
            return $user->role == 'admin_po';
        });
        Gate::define('admin_approval', function (User $user) {
            return $user->role == 'admin_approval';
        });
        Gate::define('admin_mrv', function (User $user) {
            return $user->role == 'admin_mrv';
        });
    }
}
