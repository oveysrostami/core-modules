<?php

return [
    'admin' => [
        'v1' => [
            'file' => [
                'index' => [
                    'label' => 'لیست فایل‌ها',
                    'depends_on' => [],
                ],
                'store' => [
                    'label' => 'ایجاد فایل',
                    'depends_on' => ['admin.v1.file.index'],
                ],
                'show' => [
                    'label' => 'نمایش فایل',
                    'depends_on' => ['admin.v1.file.index'],
                ],
                'destroy' => [
                    'label' => 'حذف فایل',
                    'depends_on' => ['admin.v1.file.index'],
                ],
            ],
            'image' => [
                'index' => [
                    'label' => 'لیست تصاویر',
                    'depends_on' => [],
                ],
                'store' => [
                    'label' => 'ایجاد تصویر',
                    'depends_on' => ['admin.v1.image.index'],
                ],
                'show' => [
                    'label' => 'نمایش تصویر',
                    'depends_on' => ['admin.v1.image.index'],
                ],
                'destroy' => [
                    'label' => 'حذف تصویر',
                    'depends_on' => ['admin.v1.image.index'],
                ],
            ],
        ],
    ],
];
