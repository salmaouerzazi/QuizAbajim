<?php 
if (!function_exists('arabicDate')) {
    function arabicDate($date, $format = 'd F Y')
    {
        $months = [
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
        ];

        $formattedDate = date($format, $date);

        return str_replace(array_keys($months), array_values($months), $formattedDate);
    }
}
?>