<?php

return [
    'name' => 'Admin',
    'email' => env('DEFAULT_ADMIN_EMAIL',''),
    'mobile_number' => env('DEFAULT_ADMIN_MOBILE_NUMBER',''),
    'password' => env('DEFAULT_ADMIN_PASSWORD',''),
    'passport'=> [
        'client_id' => env('ADMIN_PASSPORT_CLIENT_ID' , ''),
        'client_secret' => env('ADMIN_PASSPORT_CLIENT_SECRET' , ''),
    ]
];
