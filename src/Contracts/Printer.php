<?php

namespace IAMProperty\Printer\Contracts;

interface Printer
{
    /**
     * Print a document to a string.
     *
     * @param  \IAMProperty\Printer\Contracts\Printable|string  $view
     */
    public function print($view, array $data = []): string;
}
