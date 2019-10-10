<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Print Driver
    |--------------------------------------------------------------------------
    |
    | This is the default printer driver to use. The default is 'file' which
    | will store whatever it gets from the view to a file.
    |
    */

    'driver' => env('PRINT_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Driver Settings
    |--------------------------------------------------------------------------
    |
    | Here you can store any configuration that additional print drivers might
    | need.
    |
    */

    'drivers' => [

        'file' => [
            // The file driver doesn't have any options
        ],

    ],
];
