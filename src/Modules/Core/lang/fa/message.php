<?php

return [
    'errors' => [
        'server' => [
            'error' => 'خطای سرور',
            'exception_error' => 'خطای سرور :message',
            'throttle' => 'تلاش های زیادی برای ارتباط سیستم انجام شده. لطفا :seconds ثانیه دیگر دوباره اقدام به ورود کنید.',
        ],
        'validation' => [
            'failed' => 'مقادیر ورودی معتبر نیست.',
        ],
        'auth' => [
            'access_denied' => 'دسترسی محدود است',
            'unauthorized' => 'مجوز دسترسی را ندارید.',
            'unauthenticated' => 'وارد سیستم نشده‌اید',
            'failed' => 'اطلاعات ورود شما با هم مطابقت ندارد.',
        ],
        'routing' => [
            'method_not_allowed' => 'دسترسی به این متد مجاز نمی‌باشد.',
            'not_found' => 'صفحه مورد نظر یافت نشد.',
        ],
        'model' => [
            'not_found' => 'دیتای درخواستی وجود ندارد',
        ],
    ],
    'success' => [
        'done' => 'عملیات با موفقیت انجام شد.',
        'list_retrieved' => 'لیست با موفقیت دریافت شد.',
    ],
    'warning' => [],
];
