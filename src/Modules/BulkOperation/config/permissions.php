<?php

return [
    'admin' => [
        'v1' => [
            'bulk-operation' => [
                'index' => [
                    'label' => 'لیست عملیات گروهی',
                    'depends_on' => [],
                ],
                'store' => [
                    'label' => 'ایجاد عملیات گروهی',
                    'depends_on' => ['admin.v1.bulk-operation.index'],
                ],
                'show' => [
                    'label' => 'نمایش عملیات گروهی',
                    'depends_on' => ['admin.v1.bulk-operation.index'],
                ],
                'approve' => [
                    'label' => 'تایید عملیات گروهی',
                    'depends_on' => ['admin.v1.bulk-operation.show'],
                ],
            ],
        ],
    ],
];
