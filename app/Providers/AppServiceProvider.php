<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

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
        $path = base_path('app/certificates/isrgrootx1.pem');

        if (file_exists($path)) {
            putenv("MYSQL_ATTR_SSL_CA=$path");

            Config::set('database.connections.mysql.options', [
                \PDO::MYSQL_ATTR_SSL_CA => $path,
            ]);
        }

        
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}
