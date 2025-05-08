<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(): void
    {
        $this->mapApiRoutes();
        // Otros métodos de mapeo de rutas si es necesario.
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are loaded by the RouteServiceProvider within a group which
     * is assigned the "api" middleware group. Enjoy building your API!
     *
     * @return void
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace('App\Http\Controllers')
             ->group(base_path('routes/api.php'));
    }
}