<?php

namespace IAMProperty\Printer;

use Illuminate\Support\ServiceProvider;

class PrintServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $config = __DIR__ . '/../config/printer.php';
        $this->mergeConfigFrom($config, 'printer');

        $this->publishes([
            $config => config_path('printer.php'),
        ], 'config');

        $this->app->singleton('printer', function ($app) {
            return new PrintManager($app, $app['view'], $app['events']);
        });
    }
}
