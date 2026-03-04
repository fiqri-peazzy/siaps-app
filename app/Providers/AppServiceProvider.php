<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // View Composer for public layouts
        \Illuminate\Support\Facades\View::composer(
            ['components.public-layout', 'components.auth-public-layout', 'layouts.public', 'layouts.auth-public'],
            function ($view) {
                $profil = \App\Models\ProfilDesa::first() ?? new \App\Models\ProfilDesa();
                $view->with('profil', $profil);
            }
        );
    }
}
