<?php

return [
    'name' => 'FileManager',
    'cdn_url' => env('APP_CDN_URL'),
    'default_disk' => env('FILEMANAGER_DISK', 's3_public'),
    'public_disk' => 's3_public',
    'private' =>'s3_private',
];
