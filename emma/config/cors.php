<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'auth/google/*', 'logout'],
    'allowed_origins' => ['http://localhost:5173'],
    'allowed_headers' => ['*'],
    'allowed_methods' => ['*'],
    'supports_credentials' => true,

];
