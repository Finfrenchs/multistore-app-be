<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    //array for many feature for access user
    public static $permission = [
        'dashboard' => ['superadmin', 'admin'],
        'user-index' => ['admin'],
        'payment-update' => ['superadmin'],

    ];
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //handle access user for 1 feature
        // Gate::define('dashboard', function(User $user) {
        //     if ($user->role == 'superadmin') {
        //         return true;
        //     }
        // });

        //handle access user for many feature
        foreach (self::$permission as $feature => $roles) {
            Gate::define($feature, function(User $user) use ($roles) {
                if (in_array($user->role, $roles)) {
                    return true;
                }
            });
        }
    }
}
