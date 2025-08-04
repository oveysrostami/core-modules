<?php

return [
    'admin' => [
        'v1' => [
            'role' => [
                'index' => [
                    'label' => 'لیست نقش‌ها',
                    'depends_on' => [],
                ],
                'store' => [
                    'label' => 'ساخت نقش جدید',
                    'depends_on' => [
                        'admin.v1.role.index',
                        'admin.v1.permission.index',
                    ],
                ],
                'update' => [
                    'label' => "ویرایش نقش",
                    'depends_on' => [
                        'admin.v1.role.index',
                        'admin.v1.permission.index',
                    ],
                ],
                'destroy' => [
                    'label' => "حذف نقش",
                    'depends_on' => [
                        'admin.v1.role.index'
                    ],
                ],
                'show' => [
                    'label' => "حذف نقش",
                    'depends_on' => [
                        'admin.v1.role.index'
                    ],
                ],
            ],
            'permission' => [
                'index' => [
                    'label' => 'لیست مجوزها',
                    'depends_on' => [],
                ],
            ]
        ]
    ]
];
