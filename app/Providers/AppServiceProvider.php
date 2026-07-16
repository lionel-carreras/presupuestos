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
        // El esquema se obtiene de la solicitud y de los encabezados del
        // proxy confiable. Forzar HTTPS rompe el acceso HTTP privado :8001.
    }
}
