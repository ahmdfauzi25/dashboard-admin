<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use App\Domains\User\LoginActivity;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Blade directive for permission checks
        Blade::if('permission', function ($permission) {
            return auth()->check() && auth()->user()->hasPermission($permission);
        });

        // Blade directive for role checks
        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->hasRole($role);
        });

        // Blade directive for any role check
        Blade::if('anyrole', function (...$roles) {
            return auth()->check() && auth()->user()->hasAnyRole($roles);
        });

        // Blade directive for all roles check
        Blade::if('allroles', function (...$roles) {
            return auth()->check() && auth()->user()->hasAllRoles($roles);
        });

        // Listen login/logout and persist activity
        Event::listen(Login::class, function (Login $event) {
            try {
                LoginActivity::create([
                    'user_id' => $event->user->id,
                    'event' => 'login',
                    'ip_address' => request()->ip(),
                    'user_agent' => substr((string) request()->userAgent(), 0, 255),
                    'created_at' => now(),
                ]);
            } catch (\Throwable $e) {
                // swallow
            }
        });

        Event::listen(Logout::class, function (Logout $event) {
            try {
                LoginActivity::create([
                    'user_id' => optional($event->user)->id,
                    'event' => 'logout',
                    'ip_address' => request()->ip(),
                    'user_agent' => substr((string) request()->userAgent(), 0, 255),
                    'created_at' => now(),
                ]);
            } catch (\Throwable $e) {
                // swallow
            }
        });
    }
}
