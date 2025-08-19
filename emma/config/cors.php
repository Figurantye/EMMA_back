<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'auth/google/*', 'logout'],
    'allowed_origins' => ['http:/emmahr.vercel.app/'],
    'allowed_headers' => ['*'],
    'allowed_methods' => ['*'],
    'supports_credentials' => true,

];
