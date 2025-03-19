<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    |
    |
    */

    'accepted' => 'يجب قبول :attribute.',
    'active_url' => ':attribute ليس عنوان URL صالحًا.',
    'after' => 'يجب أن يكون :attribute تاريخًا بعد :date.',
    'after_or_equal' => 'يجب أن يكون :attribute تاريخًا مساويًا أو بعد :date.',
    'alpha' => 'قد يحتوي :attribute على حروف فقط.',
    'alpha_dash' => 'قد يحتوي :attribute على حروف، أرقام، شرطات وشرطات سفلية فقط.',
    'alpha_num' => 'قد يحتوي :attribute على حروف وأرقام فقط.',
    'array' => 'يجب أن يكون :attribute مصفوفة.',
    'before' => 'يجب أن يكون :attribute تاريخًا قبل :date.',
    'before_or_equal' => 'يجب أن يكون :attribute تاريخًا مساويًا أو قبل :date.',
    'between' => [
        'numeric' => 'يجب أن يكون :attribute بين :min و:max.',
        'file' => 'يجب أن يكون حجم الملف :attribute بين :min و:max كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف النص :attribute بين :min و:max.',
        'array' => 'يجب أن يحتوي :attribute على عناصر بين :min و:max.',
    ],
    'boolean' => 'يجب أن يكون الحقل :attribute إما صحيحًا أو خطأ.',
    'confirmed' => 'تأكيد :attribute غير مطابق.',
    'date' => ':attribute ليس تاريخًا صحيحًا.',
    'date_equals' => 'يجب أن يكون :attribute تاريخًا مساويًا ل:date.',
    'date_format' => ':attribute لا يطابق الصيغة :format.',
    'different' => 'يجب أن يكون :attribute و:other مختلفين.',
    'digits' => 'يجب أن يكون :attribute :digits رقمًا.',
    'digits_between' => 'يجب أن يكون :attribute بين :min و:max رقمًا.',
    'dimensions' => 'ال:attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct' => 'للحقل :attribute قيمة مكررة.',
    'ends_with' => 'يجب أن ينتهي :attribute بواحدة من القيم التالية: :values',
    'exists' => 'ال:attribute المحدد غير صالح.',
    'file' => 'يجب أن يكون :attribute ملفًا.',
    'filled' => 'يجب أن يحتوي الحقل :attribute على قيمة.',
    'gt' => [
        'numeric' => 'يجب أن يكون :attribute أكبر من :value.',
        'file' => 'يجب أن يكون حجم الملف :attribute أكبر من :value كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف النص :attribute أكبر من :value.',
        'array' => 'يجب أن يحتوي :attribute على أكثر من :value عنصر.',
    ],
    'gte' => [
        'numeric' => 'يجب أن يكون :attribute أكبر من أو يساوي :value.',
        'file' => 'يجب أن يكون حجم الملف :attribute أكبر من أو يساوي :value كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف النص :attribute أكبر من أو يساوي :value.',
        'array' => 'يجب أن يحتوي :attribute على :value عناصر أو أكثر.',
    ],
    'image' => 'يجب أن يكون :attribute صورةً.',
    'in' => ':attribute غير صالح.',
    'in_array' => 'حقل :attribute غير موجود في :other.',
    'integer' => 'يجب أن يكون :attribute عددًا صحيحًا.',
    'ip' => 'يجب أن يكون :attribute عنوان IP صالحًا.',
    'ipv4' => 'يجب أن يكون :attribute عنوان IPv4 صالحًا.',
    'ipv6' => 'يجب أن يكون :attribute عنوان IPv6 صالحًا.',
    'json' => 'يجب أن يكون :attribute نصًا من نوع JSON.',
    'lt' => [
        'numeric' => 'يجب أن يكون :attribute أقل من :value.',
        'file' => 'يجب أن يكون حجم الملف :attribute أقل من :value كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف النص :attribute أقل من :value.',
        'array' => 'يجب أن يحتوي :attribute على أقل من :value عناصر.',
    ],
    'lte' => [
        'numeric' => 'يجب أن يكون :attribute أقل من أو يساوي :value.',
        'file' => 'يجب أن يكون حجم الملف :attribute أقل من أو يساوي :value كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف النص :attribute أقل من أو يساوي :value.',
        'array' => 'يجب ألا يحتوي :attribute على أكثر من :value عناصر.',
    ],
    'max' => [
        'numeric' => 'قد لا يكون :attribute أكبر من :max.',
        'file' => 'قد لا يكون حجم الملف :attribute أكبر من :max كيلوبايت.',
        'string' => 'قد لا يكون عدد حروف النص :attribute أكبر من :max.',
        'array' => 'قد لا يحتوي :attribute على أكثر من :max عناصر.',
    ],
    'mimes' => 'يجب أن يكون ملفًا من نوع: :values.',
    'mimetypes' => 'يجب أن يكون ملفًا من نوع: :values.',
    'min' => [
        'numeric' => 'يجب أن يكون :attribute على الأقل :min.',
        'file' => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف النص :attribute على الأقل :min.',
        'array' => 'يجب أن يحتوي :attribute على الأقل على :min عناصر.',
    ],
    'not_in' => 'ال:attribute المحدد غير صالح.',
    'not_regex' => 'صيغة :attribute غير صالحة.',
    'numeric' => 'يجب أن يكون :attribute رقمًا.',
    'password_or_username' => 'كلمة المرور أو اسم المستخدم غير صحيح.',
    'present' => 'يجب تقديم حقل :attribute.',
    'regex' => 'صيغة :attribute غير صالحة.',
    'required' => 'حقل :attribute مطلوب.',
    'required_if' => 'حقل :attribute مطلوب عندما :other هو :value.',
    'required_unless' => 'حقل :attribute مطلوب إلا إذا كان :other في :values.',
    'required_with' => 'حقل :attribute مطلوب عند وجود :values.',
    'required_with_all' => 'حقل :attribute مطلوب عند وجود :values.',
    'required_without' => 'حقل :attribute مطلوب عند عدم وجود :values.',
    'required_without_all' => 'حقل :attribute مطلوب عند عدم وجود أي من :values.',
    'same' => 'يجب أن يتطابق :attribute مع :other.',
    'size' => [
        'numeric' => 'يجب أن يكون :attribute :size.',
        'file' => 'يجب أن يكون حجم الملف :attribute :size كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف النص :attribute :size.',
        'array' => 'يجب أن يحتوي :attribute على :size عناصر.',
    ],
    'starts_with' => 'يجب أن يبدأ :attribute بواحدة من القيم التالية: :values',
    'string' => 'يجب أن يكون :attribute نصًا.',
    'timezone' => 'يجب أن يكون :attribute منطقة زمنية صالحة.',
    'unique' => ':attribute مستعملة سابقا.',
    'uploaded' => 'فشل في تحميل :attribute.',
    'url' => 'صيغة :attribute غير صالحة.',
    'uuid' => ':attribute يجب أن يكون UUID صالحًا.',

    // validation
// validation

    'country_code' => [
        'required' => 'رمز البلد مطلوب.'
    ],
    'mobile' => [
        'required' => 'رقم الهاتف مطلوب.',
        'numeric' => 'يجب أن يكون رقم الهاتف رقميًا.',
        'unique' => 'رقم الهاتف موجود بالفعل.'
    ],
    'email' => [
        'required' => 'البريد الإلكتروني مطلوب.',
        'email' => 'البريد الإلكتروني غير صالح.',
        'max' => 'البريد الإلكتروني طويل جدًا.',
        'unique' => 'البريد الإلكتروني موجود بالفعل.'
    ],
    'term' => [
        'required' => 'يجب أن توافق على الشروط.'
    ],
    'full_name' => [
        'required' => 'الاسم الكامل مطلوب.'
    ],
    'password' => [
        'كلمة المرور غير صحيحة.',
        'required' => 'كلمة المرور مطلوبة.',
        'regex' => ' كلمة المرور يجب أن تحتوي على حرف كبير وحرف صغير ورقم ورمز.',
        'min' => 'يجب أن تكون كلمة المرور مكونة من 6 أحرف على الأقل.',
        'confirmed' => 'كلمات المرور غير متطابقة.'
    ],
    'referral_code' => [
        'exists' => 'رمز الإحالة غير صالح.'
    ],

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
            'rule-name' => 'رسالة-مخصصة',
        ],
    ],

    'captcha' => 'الكابتشا غير صحيحة...',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
