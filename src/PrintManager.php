<?php

namespace IAMProperty\Printer;

use IAMProperty\Printer\Contracts\Printer as PrinterContract;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Manager;

/**
 * @method PrinterContract driver(string $driver = null)
 */
class PrintManager extends Manager implements PrinterContract
{
    /**
     * The view factory instance.
     *
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $views;

    /**
     * The event dispatcher instance.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher|null
     */
    protected $events;

    /**
     * Create a new PrintManager instance.
     *
     * @param  \Illuminate\Contracts\Container\Container  $container
     * @param  \Illuminate\Contracts\View\Factory  $views
     * @param  \Illuminate\Contracts\Events\Dispatcher|null  $events
     * @return void
     */
    public function __construct(Container $container, Factory $views, Dispatcher $events = null)
    {
        parent::__construct($container);
        $this->views = $views;
        $this->events = $events;
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->config->get('printer.driver');
    }

    public function createFileDriver(): PrinterContract
    {
        return $this->container->make(FilePrinter::class);
    }

    /**
     * Render the given view.
     *
     * @param  string|array  $view
     * @param  array  $data
     * @return string
     */
    public function render($view, array $data = [])
    {
        return $this->views->make($view, $data)->render();
    }

    /**
     * Print a page to a string.
     *
     * @param  \IAMProperty\Printer\Printable|string  $view
     * @param  array  $data
     * @return string
     */
    public function raw($view, array $data = []): string
    {
        return $this->driver()->raw($view, $data);
    }

    /**
     * Print a page to a file.
     *
     * @param  string  $file
     * @param  \IAMProperty\Printer\Printable|string  $view
     * @param  array  $data
     * @return void
     */
    public function print($file, $view, array $data = [])
    {
        $this->driver()->print($file, $view, $data);
    }
}
