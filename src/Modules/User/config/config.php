<?php

return [
    'name' => 'User',
    'passport' => [
        'client_id' => env('USER_PASSPORT_CLIENT_ID', ''),
        'client_secret' => env('USER_PASSPORT_CLIENT_SECRET', ''),
    ],
];
