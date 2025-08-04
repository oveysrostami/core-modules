<?php

return [
    'admin' => [
        'v1' => [
            'wallet' => [
                'payment-link' => [
                    'index' => [
                        'label' => 'لیست لینک‌های پرداخت',
                        'depends_on' => [],
                    ],
                    'store' => [
                        'label' => 'ایجاد لینک پرداخت',
                        'depends_on' => [
                            'admin.v1.wallet.payment-link.index',
                        ],
                    ],
                    'show' => [
                        'label' => 'نمایش لینک پرداخت',
                        'depends_on' => [
                            'admin.v1.wallet.payment-link.index',
                        ],
                    ],
                    'update' => [
                        'label' => 'ویرایش لینک پرداخت',
                        'depends_on' => [
                            'admin.v1.wallet.payment-link.index',
                        ],
                    ],
                    'destroy' => [
                        'label' => 'حذف لینک پرداخت',
                        'depends_on' => [
                            'admin.v1.wallet.payment-link.index',
                        ],
                    ],
                ]
            ],
            'wallet-cash-in-request' => [
                'index' => [
                    'label' => 'لیست درخواست‌های واریز',
                    'depends_on' => [],
                ],
                'approve' => [
                    'label' => 'تایید درخواست واریز',
                    'depends_on' => ['admin.v1.wallet-cash-in-request.index'],
                ],
                'failed' => [
                    'label' => 'ثبت خطا برای درخواست واریز',
                    'depends_on' => ['admin.v1.wallet-cash-in-request.index'],
                ],
                'reject' => [
                    'label' => 'رد درخواست واریز',
                    'depends_on' => ['admin.v1.wallet-cash-in-request.index'],
                ],
                'cancel' => [
                    'label' => 'لغو درخواست واریز',
                    'depends_on' => ['admin.v1.wallet-cash-in-request.index'],
                ],
            ],
            'wallet-cash-out-request' => [
                'index' => [
                    'label' => 'لیست درخواست‌های برداشت',
                    'depends_on' => [],
                ],
                'approve' => [
                    'label' => 'تایید درخواست برداشت',
                    'depends_on' => ['admin.v1.wallet-cash-out-request.index'],
                ],
                'failed' => [
                    'label' => 'ثبت خطا برای درخواست برداشت',
                    'depends_on' => ['admin.v1.wallet-cash-out-request.index'],
                ],
                'reject' => [
                    'label' => 'رد درخواست برداشت',
                    'depends_on' => ['admin.v1.wallet-cash-out-request.index'],
                ],
            ],
            'wallet-purchase-request' => [
                'index' => [
                    'label' => 'لیست درخواست‌های خرید',
                    'depends_on' => [],
                ],
                'approve' => [
                    'label' => 'تایید درخواست خرید',
                    'depends_on' => ['admin.v1.wallet-purchase-request.index'],
                ],
                'failed' => [
                    'label' => 'ثبت خطا برای درخواست خرید',
                    'depends_on' => ['admin.v1.wallet-purchase-request.index'],
                ],
                'reject' => [
                    'label' => 'رد درخواست خرید',
                    'depends_on' => ['admin.v1.wallet-purchase-request.index'],
                ],
            ],
            'wallet-transfer-request' => [
                'index' => [
                    'label' => 'لیست درخواست‌های انتقال',
                    'depends_on' => [],
                ],
                'approve' => [
                    'label' => 'تایید درخواست انتقال',
                    'depends_on' => ['admin.v1.wallet-transfer-request.index'],
                ],
                'failed' => [
                    'label' => 'ثبت خطا برای درخواست انتقال',
                    'depends_on' => ['admin.v1.wallet-transfer-request.index'],
                ],
                'reject' => [
                    'label' => 'رد درخواست انتقال',
                    'depends_on' => ['admin.v1.wallet-transfer-request.index'],
                ],
            ],
        ],
    ],
];
