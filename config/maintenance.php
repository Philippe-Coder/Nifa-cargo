<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode View
    |--------------------------------------------------------------------------
    |
    | This view will be shown when the application is in maintenance mode.
    | You can customize this view to match your application's design.
    |
    */

    'view' => 'vendor.maintenance.index',

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Secret
    |--------------------------------------------------------------------------
    |
    | This secret allows you to bypass maintenance mode with a secret token.
    | You can access the application by visiting /secret-token
    |
    */

    'secret' => env('MAINTENANCE_SECRET', 'nifa-maintenance-2023'),

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Status File
    |--------------------------------------------------------------------------
    |
    | This file will be created when the application is put into maintenance mode
    | and deleted when maintenance mode is disabled.
    |
    */

    'file' => storage_path('framework/maintenance.php'),

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Retry Time
    |--------------------------------------------------------------------------
    |
    | This value specifies the number of seconds after which the browser should
    | retry accessing the application when in maintenance mode.
    |
    */

    'retry' => 60,

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Bypass IPs
    |--------------------------------------------------------------------------
    |
    | These IP addresses will be able to access the application while it is
    | in maintenance mode.
    |
    */

    'allowed_ips' => [
        '127.0.0.1',
        '::1',
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Bypass Tokens
    |--------------------------------------------------------------------------
    |
    | These tokens will allow access to the application during maintenance mode.
    | You can generate secure tokens using the `php artisan down --secret` command.
    |
    */

    'tokens' => [
        // Add your maintenance mode bypass tokens here
    ],
];
