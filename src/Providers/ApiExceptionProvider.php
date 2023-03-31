<?php

namespace Anil\ExceptionResponse\Providers;

use Illuminate\Support\ServiceProvider;

class ApiExceptionProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/exception.php' => config_path('exception.php'),
        ], 'config');
    }


    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/exception.php', 'exception');
    }

}