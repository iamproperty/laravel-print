<?php

namespace IAMProperty\Printer;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PrintServiceProvider extends ServiceProvider implements DeferrableProvider
{
    private const CONFIG_FILE = __DIR__.'/../config/printer.php';

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
        $this->registerRendererManager();
        $this->registerPrinter();
    }

    /**
     * Register the printer config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(self::CONFIG_FILE, 'printer');

        $this->publishes([
            self::CONFIG_FILE => config_path('printer.php'),
        ], 'config');
    }

    /**
     * Register the printer manager instance.
     *
     * @return void
     */
    protected function registerRendererManager()
    {
        $this->app->singleton('printer.renderer', function ($app) {
            return new RendererManager($app);
        });
    }

    /**
     * Register the printer config.
     *
     * @return void
     */
    protected function registerPrinter()
    {
        $this->app->singleton('printer', function ($app) {
            $printer = new Printer($app['view'], $app['printer.renderer']);

            return $printer;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'printer', 'printer.renderer',
        ];
    }
}
