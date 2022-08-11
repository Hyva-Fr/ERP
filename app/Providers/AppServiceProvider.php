<?php

namespace App\Providers;

use Blade;
use Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('perms', function($expression) {
            return "<?php if (Auth::user()->hasPermissions($expression)): ?>";
        });

        Blade::directive('endperms', function($expression) {
            return "<?php endif; ?>";
        });
    }
}
