<?php

return [
    'admin' => [
        'v1' => [
            'internal-notification' => [
                'index' => [
                    'label' => 'لیست',
                    'depends_on' => [],
                ],
                'markAsRead' => [
                    'label' => 'خواندن نوتیفیکیشن',
                    'depends_on' => ['admin.v1.internal-notification.index'],
                ],
                'markAllAsRead' => [
                    'label' => 'خواندن همه نوتیفیکیشن‌ها',
                    'depends_on' => ['admin.v1.internal-notification.index'],
                ],
                'destroy' => [
                    'label' => 'حذف نوتیفیکیشن',
                    'depends_on' => ['admin.v1.internal-notification.index'],
                ],
            ],
        ],
    ],
    'v1' => [
        'internal-notification' => [
            'index' => [
                'label' => 'لیست',
                'depends_on' => [],
            ],
            'markAsRead' => [
                'label' => 'خواندن نوتیفیکیشن',
                'depends_on' => ['v1.internal-notification.index'],
            ],
            'markAllAsRead' => [
                'label' => 'خواندن همه نوتیفیکیشن‌ها',
                'depends_on' => ['v1.internal-notification.index'],
            ],
            'destroy' => [
                'label' => 'حذف نوتیفیکیشن',
                'depends_on' => ['v1.internal-notification.index'],
            ],
        ],
    ],
];
