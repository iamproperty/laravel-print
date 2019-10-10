<?php

namespace IAMProperty\Printer\Contracts;

interface Printable
{
    /**
     * Print the page using using the given printer.
     *
     * @param  \IAMProperty\Printer\Contracts\Printer  $printer
     * @return string
     */
    public function print(Printer $printer): string;
}
