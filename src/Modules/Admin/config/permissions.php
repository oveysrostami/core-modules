<?php

return [
    'admin' => [
        'v1' => [
            'admin' => [
                'index' => [
                    'label' => 'لیست ادمین‌ها',
                    'depends_on' => [],
                ],
                'store' => [
                    'label' => 'ایجاد ادمین',
                    'depends_on' => [
                        'admin.v1.admin.index'
                    ],
                ],
                'show' => [
                    'label' => 'نمایش ادمین',
                    'depends_on' => [
                        'admin.v1.admin.index'
                    ],
                ],
                'update' => [
                    'label' => 'ویرایش ادمین',
                    'depends_on' => [
                        'admin.v1.admin.index'
                    ],
                ],
                'destroy' => [
                    'label' => 'حذف ادمین',
                    'depends_on' => [
                        'admin.v1.admin.index'
                    ],
                ],
                'toggle-ban' => [
                    'label' => 'تغییر وضعیت بن',
                    'depends_on' => [
                        'admin.v1.admin.index'
                    ],
                ],
            ],
            'auth' => [
                'logout' => [
                    'label' => 'خروج ادمین',
                    'depends_on' => [],
                ],
                'me' => [
                    'label' => 'نمایش اطلاعات من',
                    'depends_on' => [],
                ],
            ],
        ],
    ],
];
