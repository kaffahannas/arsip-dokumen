<?php

if (! function_exists('format_file_size')) {
    /**
     * Formats a byte count into a human-readable KB/MB string.
     */
    function format_file_size($bytes): string
    {
        $bytes = (int) $bytes;

        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1, ',', '.') . ' MB';
        }

        return number_format($bytes / 1024, 1, ',', '.') . ' KB';
    }
}

if (! function_exists('format_datetime')) {
    /**
     * Formats a database datetime into a readable Indonesian date.
     */
    function format_datetime(?string $datetime): string
    {
        if ($datetime === null || $datetime === '') {
            return '-';
        }

        $timestamp = strtotime($datetime);

        if ($timestamp === false) {
            return '-';
        }

        $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
        ];

        return date('d', $timestamp)
            . ' ' . $months[(int) date('n', $timestamp)]
            . ' ' . date('Y H:i', $timestamp);
    }
}
