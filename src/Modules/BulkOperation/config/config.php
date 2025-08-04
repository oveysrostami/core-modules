<?php

return [
    'name' => 'BulkOperation',

    'jobs' => [
        'import_user' => \Modules\BulkOperation\Jobs\ImportUserJob::class,
    ],
];
