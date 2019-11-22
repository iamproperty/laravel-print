<?php

namespace IAMProperty\Printer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string print(\IAMProperty\Printer\Contracts\Printable|string|array $view, array $data = [])
 *
 * @see \IAMProperty\Printer\Printer
 */
class Printer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'printer';
    }
}
