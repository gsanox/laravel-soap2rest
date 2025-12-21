<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Route Prefix
    |--------------------------------------------------------------------------
    |
    | The prefix for the routes registered by this package. You can change
    | this to fit your application's routing structure.
    |
    */
    'prefix' => 'api',

    /*
    |--------------------------------------------------------------------------
    | API Middleware
    |--------------------------------------------------------------------------
    |
    | The middleware to apply to the routes registered by this package. You
    | can change this to add your own middleware or change the default
    | authentication method.
    |
    */
    'middleware' => ['api', 'auth:sanctum'],
];
