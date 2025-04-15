<?php

return [
    'MATERIAL_COLORS' => [
        'العربية' => '#f1c5c9',
        'رياضيات' => '#8EACCD',
        'الإيقاظ العلمي' => '#e8dfd0',
        'الفرنسية' => '#A6B37D',
        'المواد الاجتماعية' => '#F6D7A7',
        'الإنجليزية' => '#BAABDA',
    ],
    'DAYS' => ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
    'MONTHS' => [
        'January' => 'جانفي',
        'February' => 'فيفري',
        'March' => 'مارس',
        'April' => 'أفريل',
        'May' => 'ماي',
        'June' => 'جوان',
        'July' => 'جويلية',
        'August' => 'أوت',
        'September' => 'سبتمبر',
        'October' => 'أكتوبر',
        'November' => 'نوفمبر',
        'December' => 'ديسمبر',
    ],
    'CARD_TYPES' => [
        'school' => 'SC',
        'pos' => 'POS',
        'other' => 'OT',
    ],
    'RIB_BANK' => 123456789,
    'USER_BANK_NAME' => 'ABAJIM',

    'patterns' => [
        'arabe' => [
            'question' => '/سؤال\s+\d+\s+\((.*?)\)\s*:(.*?)((?=سؤال\s+\d+\s+\(|\z))/us',
            'match' => '/العمود أ\s*:(.*?)العمود ب\s*:(.*?)المطابقات\s*:(.*)/us',
            'tf' => '/بيان\s*:(.*?)الإجابة الصحيحة\s*:\s*(.*)/us',
            'mcq' => '/(.*?)الإجابة الصحيحة\s*:\s*(.*)/us',
            'choices' => '/^[أ-ي]\)/u',
        ],
        'français' => [
            'question' => '/Question\s+\d+\s+\((.*?)\)\s*:(.*?)((?=Question\s+\d+\s+\(|\z))/us',
            'match' => '/Colonne A\s*:(.*?)Colonne B\s*:(.*?)Correspondances\s*:(.*)/us',
            'tf' => '/Énoncé\s*:\s*(.*?)Réponse correcte\s*:\s*(.*)/us',
            'mcq' => '/(.*?)Réponse correcte\s*:\s*(.*)/us',
            'choices' => '/^[A-D]\)/u',
        ],
        'anglais' => [
            'question' => '/Question\s+\d+\s+\((.*?)\)\s*:(.*?)((?=Question\s+\d+\s+\(|\z))/us',
            'match' => '/Column A\s*:(.*?)Column B\s*:(.*?)Matches\s*:(.*)/us',
            'tf' => '/Statement\s*:\s*(.*?)Correct answer\s*:\s*(.*)/us',
            'mcq' => '/(.*?)Correct answer\s*:\s*(.*)/us',
            'choices' => '/^[A-D]\)/u',
        ],
    ],
];
