<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Assets paths
    |--------------------------------------------------------------------------
    |
    | This value defines a list of base paths in order to find your application
    | compiled assets. The key is the path to your directory of assets and
    | the value is its base URL.
    |
    */
    'paths' => [
        web_path('dist') => rtrim(config('app.url'), '\/').'/dist'
    ],
];
