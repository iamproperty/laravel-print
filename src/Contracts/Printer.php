<?php

namespace IAMProperty\Printer\Contracts;

interface Printer
{
    /**
     * Print a document to a string.
     *
     * @param  \IAMProperty\Printer\Contracts\Printable|string  $view
     * @param  array  $data
     * @return string
     */
    public function print($view, array $data = []): string;
}
