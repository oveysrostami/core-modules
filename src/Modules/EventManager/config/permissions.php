<?php

return [
    'admin' => [
        'v1' => [
            'event-logs' => [
                'index' => [
                    'label' => 'لیست',
                    'depends_on' => [],
                ],
                'show' => [
                    'label' => 'نمایش جزئیات',
                    'depends_on' => ['admin.v1.event-logs.index'],
                ],
                'retry' => [
                    'label' => 'ارسال مجدد',
                    'depends_on' => ['admin.v1.event-logs.index'],
                ],
            ],
        ],
    ],
];
