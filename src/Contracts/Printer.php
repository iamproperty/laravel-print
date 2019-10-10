<?php

namespace IAMProperty\Printer\Contracts;

interface Printer
{
    /**
     * Print a page to a string.
     *
     * @param  \IAMProperty\Printer\Printable|string  $view
     * @param  array  $data
     * @return string
     */
    public function raw($view, array $data = []): string;

    /**
     * Print a page to a file.
     *
     * @param  string  $file
     * @param  \IAMProperty\Printer\Printable|string  $view
     * @param  array  $data
     * @return void
     */
    public function print($file, $view, array $data = []);
}
