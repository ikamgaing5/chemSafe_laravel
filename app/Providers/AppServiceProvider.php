<?php

namespace App\Providers;

use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);
        Route::middleware('web')
        ->middleware(AdminMiddleware::class)
        ->group(base_path('routes/web.php'));

    // Si tu veux enregistrer un alias (ex: 'AdminMiddleware')
        Route::aliasMiddleware('auth.middle', AdminMiddleware::class);

    }
}
