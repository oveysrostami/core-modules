<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'فیلد :attribute باید پذیرفته شود.',
    'accepted_if' => 'فیلد :attribute باید زمانی که :other برابر :value است پذیرفته شود.',
    'active_url' => 'فیلد :attribute باید یک آدرس اینترنتی معتبر باشد.',
    'after' => 'فیلد :attribute باید تاریخی بعد از :date باشد.',
    'after_or_equal' => 'فیلد :attribute باید تاریخی بعد از یا برابر با :date باشد.',
    'alpha' => 'فیلد :attribute فقط می‌تواند شامل حروف باشد.',
    'alpha_dash' => 'فیلد :attribute فقط می‌تواند شامل حروف، اعداد، خط تیره و زیرخط (_) باشد.',
    'alpha_num' => 'فیلد :attribute فقط می‌تواند شامل حروف و اعداد باشد.',
    'any_of' => 'مقدار وارد شده برای فیلد :attribute نامعتبر است.',
    'array' => 'فیلد :attribute باید یک آرایه باشد.',
    'ascii' => 'فیلد :attribute فقط می‌تواند شامل کاراکترهای الفبایی و نمادهای تک‌بایتی باشد.',
    'before' => 'فیلد :attribute باید تاریخی قبل از :date باشد.',
    'before_or_equal' => 'فیلد :attribute باید تاریخی قبل از یا برابر با :date باشد.',
    'between' => [
        'array' => 'تعداد آیتم‌های فیلد :attribute باید بین :min تا :max باشد.',
        'file' => 'حجم فایل :attribute باید بین :min تا :max کیلوبایت باشد.',
        'numeric' => 'مقدار فیلد :attribute باید بین :min تا :max باشد.',
        'string' => 'تعداد کاراکترهای فیلد :attribute باید بین :min تا :max باشد.',
    ],
    'boolean' => 'فیلد :attribute فقط می‌تواند true یا false باشد.',
    'can' => 'مقدار فیلد :attribute مجاز نیست.',
    'confirmed' => 'تأییدیه فیلد :attribute با مقدار وارد شده مطابقت ندارد.',
    'contains' => 'فیلد :attribute باید حداقل یکی از مقادیر الزامی را داشته باشد.',
    'current_password' => 'رمز عبور نادرست است.',
    'date' => 'فیلد :attribute باید یک تاریخ معتبر باشد.',
    'date_equals' => 'فیلد :attribute باید برابر با تاریخ :date باشد.',
    'date_format' => 'قالب فیلد :attribute باید مطابق با فرمت :format باشد.',
    'decimal' => 'فیلد :attribute باید دارای :decimal رقم اعشار باشد.',
    'declined' => 'فیلد :attribute باید رد شود.',
    'declined_if' => 'فیلد :attribute باید زمانی که :other برابر :value است رد شود.',
    'different' => 'فیلد :attribute و :other باید با یکدیگر متفاوت باشند.',
    'digits' => 'فیلد :attribute باید :digits رقم باشد.',
    'digits_between' => 'فیلد :attribute باید بین :min تا :max رقم باشد.',
    'dimensions' => 'ابعاد تصویر در فیلد :attribute نامعتبر است.',
    'distinct' => 'فیلد :attribute دارای مقدار تکراری است.',
    'doesnt_end_with' => 'فیلد :attribute نباید با یکی از موارد زیر پایان یابد: :values.',
    'doesnt_start_with' => 'فیلد :attribute نباید با یکی از موارد زیر شروع شود: :values.',
    'email' => 'فیلد :attribute باید یک ایمیل معتبر باشد.',
    'ends_with' => 'فیلد :attribute باید با یکی از موارد زیر پایان یابد: :values.',
    'enum' => 'مقدار انتخاب شده برای فیلد :attribute نامعتبر است.',
    'exists' => 'مقدار انتخاب شده برای فیلد :attribute معتبر نیست.',
    'extensions' => 'فایل فیلد :attribute باید یکی از پسوندهای زیر را داشته باشد: :values.',
    'file' => 'فیلد :attribute باید یک فایل باشد.',
    'filled' => 'فیلد :attribute باید دارای مقدار باشد.',
    'gt' => [
        'array' => 'فیلد :attribute باید بیش از :value آیتم داشته باشد.',
        'file' => 'حجم فایل :attribute باید بیش از :value کیلوبایت باشد.',
        'numeric' => 'مقدار فیلد :attribute باید بزرگ‌تر از :value باشد.',
        'string' => 'تعداد کاراکترهای فیلد :attribute باید بیش از :value باشد.',
    ],
    'gte' => [
        'array' => 'فیلد :attribute باید حداقل :value آیتم یا بیشتر داشته باشد.',
        'file' => 'حجم فایل :attribute باید برابر یا بیشتر از :value کیلوبایت باشد.',
        'numeric' => 'مقدار فیلد :attribute باید برابر یا بیشتر از :value باشد.',
        'string' => 'تعداد کاراکترهای فیلد :attribute باید برابر یا بیشتر از :value باشد.',
    ],
    'hex_color' => 'فیلد :attribute باید یک رنگ هگزادسیمال معتبر باشد.',
    'image' => 'فیلد :attribute باید یک تصویر باشد.',
    'in' => 'مقدار انتخاب‌شده برای فیلد :attribute نامعتبر است.',
    'in_array' => 'فیلد :attribute باید در :other موجود باشد.',
    'in_array_keys' => 'فیلد :attribute باید حداقل یکی از کلیدهای زیر را داشته باشد: :values.',
    'integer' => 'فیلد :attribute باید یک عدد صحیح باشد.',
    'ip' => 'فیلد :attribute باید یک آدرس IP معتبر باشد.',
    'ipv4' => 'فیلد :attribute باید یک آدرس IPv4 معتبر باشد.',
    'ipv6' => 'فیلد :attribute باید یک آدرس IPv6 معتبر باشد.',
    'json' => 'فیلد :attribute باید یک رشته JSON معتبر باشد.',
    'list' => 'فیلد :attribute باید یک لیست باشد.',
    'lowercase' => 'فیلد :attribute باید با حروف کوچک نوشته شود.',
    'lt' => [
        'array' => 'فیلد :attribute باید کمتر از :value آیتم داشته باشد.',
        'file' => 'حجم فایل :attribute باید کمتر از :value کیلوبایت باشد.',
        'numeric' => 'مقدار فیلد :attribute باید کمتر از :value باشد.',
        'string' => 'تعداد کاراکترهای فیلد :attribute باید کمتر از :value باشد.',
    ],
    'lte' => [
        'array' => 'فیلد :attribute نباید بیشتر از :value آیتم داشته باشد.',
        'file' => 'حجم فایل :attribute باید برابر یا کمتر از :value کیلوبایت باشد.',
        'numeric' => 'مقدار فیلد :attribute باید برابر یا کمتر از :value باشد.',
        'string' => 'تعداد کاراکترهای فیلد :attribute باید برابر یا کمتر از :value باشد.',
    ],
    'mac_address' => 'فیلد :attribute باید یک آدرس MAC معتبر باشد.',
    'max' => [
        'array' => 'فیلد :attribute نباید بیشتر از :max آیتم داشته باشد.',
        'file' => 'حجم فایل :attribute نباید بیشتر از :max کیلوبایت باشد.',
        'numeric' => 'مقدار فیلد :attribute نباید بیشتر از :max باشد.',
        'string' => 'تعداد کاراکترهای فیلد :attribute نباید بیشتر از :max باشد.',
    ],
    'max_digits' => 'فیلد :attribute نباید بیش از :max رقم داشته باشد.',
    'mimes' => 'فایل فیلد :attribute باید از نوع: :values باشد.',
    'mimetypes' => 'فایل فیلد :attribute باید از نوع: :values باشد.',
    'min' => [
        'array' => 'فیلد :attribute باید حداقل :min آیتم داشته باشد.',
        'file' => 'حجم فایل :attribute باید حداقل :min کیلوبایت باشد.',
        'numeric' => 'مقدار فیلد :attribute باید حداقل :min باشد.',
        'string' => 'تعداد کاراکترهای فیلد :attribute باید حداقل :min باشد.',
    ],
    'min_digits' => 'فیلد :attribute باید حداقل :min رقم داشته باشد.',
    'missing' => 'فیلد :attribute باید وجود نداشته باشد.',
    'missing_if' => 'فیلد :attribute باید زمانی که :other برابر :value است وجود نداشته باشد.',
    'missing_unless' => 'فیلد :attribute باید مگر در صورتی که :other برابر :value باشد، وجود نداشته باشد.',
    'missing_with' => 'فیلد :attribute باید زمانی که :values وجود دارد، وجود نداشته باشد.',
    'missing_with_all' => 'فیلد :attribute باید زمانی که همه‌ی :values وجود دارند، وجود نداشته باشد.',
    'multiple_of' => 'فیلد :attribute باید مضربی از :value باشد.',
    'not_in' => 'مقدار انتخاب‌شده برای فیلد :attribute نامعتبر است.',
    'not_regex' => 'فرمت فیلد :attribute نامعتبر است.',
    'numeric' => 'فیلد :attribute باید یک عدد باشد.',
    'password' => [
        'letters' => 'فیلد :attribute باید حداقل یک حرف داشته باشد.',
        'mixed' => 'فیلد :attribute باید حداقل یک حرف بزرگ و یک حرف کوچک داشته باشد.',
        'numbers' => 'فیلد :attribute باید حداقل یک عدد داشته باشد.',
        'symbols' => 'فیلد :attribute باید حداقل یک نماد (symbol) داشته باشد.',
        'uncompromised' => 'فیلد :attribute در یک نشت داده مشاهده شده است. لطفاً رمز عبور دیگری انتخاب کنید.',
    ],
    'present' => 'فیلد :attribute باید وجود داشته باشد.',
    'present_if' => 'فیلد :attribute باید زمانی که :other برابر :value است، وجود داشته باشد.',
    'present_unless' => 'فیلد :attribute باید مگر زمانی که :other برابر :value باشد، وجود داشته باشد.',
    'present_with' => 'فیلد :attribute باید زمانی که :values وجود دارد، حاضر باشد.',
    'present_with_all' => 'فیلد :attribute باید زمانی که همه‌ی :values وجود دارند، حاضر باشد.',

    'prohibited' => 'فیلد :attribute مجاز نیست.',
    'prohibited_if' => 'فیلد :attribute زمانی که :other برابر :value باشد، مجاز نیست.',
    'prohibited_if_accepted' => 'فیلد :attribute زمانی که :other پذیرفته شده باشد، مجاز نیست.',
    'prohibited_if_declined' => 'فیلد :attribute زمانی که :other رد شده باشد، مجاز نیست.',
    'prohibited_unless' => 'فیلد :attribute مجاز نیست مگر اینکه :other یکی از مقادیر :values باشد.',
    'prohibits' => 'وجود فیلد :attribute مانع از وجود فیلد :other می‌شود.',

    'regex' => 'قالب فیلد :attribute نامعتبر است.',
    'required' => 'وارد کردن فیلد :attribute الزامی است.',
    'required_array_keys' => 'فیلد :attribute باید شامل کلیدهای زیر باشد: :values.',
    'required_if' => 'فیلد :attribute زمانی الزامی است که :other برابر :value باشد.',
    'required_if_accepted' => 'فیلد :attribute زمانی الزامی است که :other پذیرفته شده باشد.',
    'required_if_declined' => 'فیلد :attribute زمانی الزامی است که :other رد شده باشد.',
    'required_unless' => 'فیلد :attribute الزامی است مگر اینکه :other یکی از مقادیر :values باشد.',
    'required_with' => 'فیلد :attribute زمانی الزامی است که :values موجود باشد.',
    'required_with_all' => 'فیلد :attribute زمانی الزامی است که همه‌ی :values موجود باشند.',
    'required_without' => 'فیلد :attribute زمانی الزامی است که :values موجود نباشد.',
    'required_without_all' => 'فیلد :attribute زمانی الزامی است که هیچ‌یک از :values موجود نباشند.',

    'same' => 'فیلد :attribute باید با فیلد :other یکسان باشد.',
    'size' => [
        'array' => 'فیلد :attribute باید شامل :size آیتم باشد.',
        'file' => 'حجم فایل :attribute باید دقیقاً :size کیلوبایت باشد.',
        'numeric' => 'مقدار فیلد :attribute باید دقیقاً :size باشد.',
        'string' => 'تعداد کاراکترهای فیلد :attribute باید دقیقاً :size باشد.',
    ],
    'starts_with' => 'فیلد :attribute باید با یکی از مقادیر زیر شروع شود: :values.',
    'string' => 'فیلد :attribute باید یک رشته (string) باشد.',
    'timezone' => 'فیلد :attribute باید یک منطقه زمانی معتبر باشد.',
    'unique' => 'مقدار فیلد :attribute قبلاً ثبت شده است.',
    'uploaded' => 'بارگذاری فایل :attribute انجام نشد.',
    'uppercase' => 'فیلد :attribute باید با حروف بزرگ نوشته شود.',
    'url' => 'فیلد :attribute باید یک آدرس URL معتبر باشد.',
    'ulid' => 'فیلد :attribute باید یک ULID معتبر باشد.',
    'uuid' => 'فیلد :attribute باید یک UUID معتبر باشد.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        "name" => "نام",
        "username" => "نام کاربری",
        "email" => "پست الکترونیکی",
        "first_name" => "نام",
        "last_name" => "نام خانوادگی",
        "password" => "رمز عبور",
        "password_confirmation" => "تاییدیه ی رمز عبور",
        "city" => "شهر",
        "country" => "کشور",
        "address" => "نشانی",
        "phone" => "تلفن",
        "mobile" => "تلفن همراه",
        "age" => "سن",
        "sex" => "جنسیت",
        "gender" => "جنسیت",
        "day" => "روز",
        "month" => "ماه",
        "year" => "سال",
        "hour" => "ساعت",
        "minute" => "دقیقه",
        "second" => "ثانیه",
        "title" => "عنوان",
        "text" => "متن",
        "content" => "محتوا",
        "description" => "توضیحات",
        "excerpt" => "گلچین کردن",
        "date" => "تاریخ",
        "time" => "زمان",
        "available" => "موجود",
        "size" => "اندازه",
        "body" => "متن",
        "imageUrl" => "تصویر",
        "videoUrl" => "آدرس ویدیو",
        "slug" => "نامک",
        "tags" => "تگ ها",
        "category" => "دسته",
        "story" => "داستان",
        'number' => 'شماره قسمت',
        'price' => 'قیمت دوره',
        'course_id' => 'دوره مورد نظر',
        'fileUrl' => 'آدرس فایل',
        'enSlug' => 'نامک انگلیسی',
        'percent' => 'درصد',
        'images' => 'تصویر',
        'userName' => 'نام کاربری',
        'comment' => 'متن نظرات شما',
        'coupon' => 'کد تخفیف',
        'amount' => 'مقدار تخفیف',
        'expire' => 'زمان تخفیف',
        'avatar' => 'تصویر پروفایل',
        'priority' => 'الویت',
        'message' => 'متن پیام',
        'is_active' => 'وضعیت فعال',
    ],

];
