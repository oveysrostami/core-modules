<?php

return [
    'admin' => [
        'v1' => [
            'user' => [
                'index' => [
                    'label' => 'لیست کاربران',
                    'depends_on' => [],
                ],
                'store' => [
                    'label' => 'ایجاد کاربر',
                    'depends_on' => ['admin.v1.user.index'],
                ],
                'show' => [
                    'label' => 'نمایش کاربر',
                    'depends_on' => ['admin.v1.user.index'],
                ],
                'update' => [
                    'label' => 'ویرایش کاربر',
                    'depends_on' => ['admin.v1.user.index'],
                ],
                'destroy' => [
                    'label' => 'حذف کاربر',
                    'depends_on' => ['admin.v1.user.index'],
                ],
                'toggle-ban' => [
                    'label' => 'تغییر وضعیت بن',
                    'depends_on' => ['admin.v1.user.index'],
                ],
            ],
        ],
    ],
    'v1' => [
        'user' => [
            'show' => [
                'label' => 'نمایش پروفایل',
                'depends_on' => [],
            ],
            'update' => [
                'label' => 'ویرایش پروفایل',
                'depends_on' => ['v1.user.show'],
            ],
        ],
        'auth' => [
            'logout' => [
                'label' => 'خروج کاربر',
                'depends_on' => [],
            ],
            'me' => [
                'label' => 'نمایش اطلاعات من',
                'depends_on' => [],
            ],
        ],
    ],
];
