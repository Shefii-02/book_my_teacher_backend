<?php
// config/cors.php
return [

    'paths' => ['api/*', 'storage/*', 'uploads/*', 'public/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'], // you can restrict to your domain later

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
