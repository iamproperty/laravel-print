<?php

namespace IAMProperty\Printer\Contracts;

interface Printable
{
    /**
     * Print the page using using the given printer.
     */
    public function print(Printer $printer): string;
}
