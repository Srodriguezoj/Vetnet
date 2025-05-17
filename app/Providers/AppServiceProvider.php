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
        if ($sslCert = env('DB_SSL_CA_CONTENT')) {
            $path = '/tmp/isrgrootx1.pem';
            file_put_contents($path, $sslCert);
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
