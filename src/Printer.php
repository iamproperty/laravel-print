<?php

namespace IAMProperty\Printer;

use IAMProperty\Printer\Contracts\Printable;
use IAMProperty\Printer\Contracts\Printer as PrinterContract;
use Illuminate\Contracts\View\Factory;

class Printer implements PrinterContract
{
    /**
     * The view factory instance.
     *
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $views;

    /**
     * The renderer instance.
     *
     * @var \IAMProperty\Printer\RendererManager
     */
    protected $renderer;

    /**
     * Create a new PrintManager instance.
     *
     * @return void
     */
    public function __construct(Factory $views, RendererManager $printerManager)
    {
        $this->views = $views;
        $this->renderer = $printerManager;
    }

    /**
     * Render the given view.
     *
     * @param  string|array  $view
     */
    public function render($view, array $data = []): string
    {
        return $this->views->make($view, $data)->render();
    }

    /**
     * Print a document to a string.
     *
     * @param  \IAMProperty\Printer\Contracts\Printable|string  $view
     */
    public function print($view, array $data = []): string
    {
        if ($view instanceof Printable) {
            return $this->printPrintable($view);
        }

        $document = $this->render($view, $data);

        return $this->renderer->render($document);
    }

    /**
     * Print the given printable.
     *
     * @return mixed
     */
    protected function printPrintable(Printable $printable)
    {
        return $printable->print($this);
    }

    /**
     * The mime type of the rendered document.
     */
    public function format(): string
    {
        return $this->renderer->format();
    }
}
