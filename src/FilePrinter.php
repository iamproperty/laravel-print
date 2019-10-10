<?php

namespace IAMProperty\Printer;

use IAMProperty\Printer\Contracts\Printer as PrinterContract;
use Illuminate\Contracts\Filesystem\Filesystem;

class FilePrinter implements PrinterContract
{
    /** @var PrintManager */
    protected $printManager;
    /** @var Filesystem */
    protected $filesystem;

    /**
     * FilePrinter constructor.
     *
     * @param  PrintManager  $printManager
     * @param  Filesystem  $filesystem
     */
    public function __construct(PrintManager $printManager, Filesystem $filesystem)
    {
        $this->printManager = $printManager;
        $this->filesystem = $filesystem;
    }

    public function raw($view, array $data = []): string
    {
        return $this->printManager->render($view, $data);
    }

    public function print($file, $view, array $data = [])
    {
        $this->filesystem->put($file, $this->raw($view, $data));
    }
}
