<?php
if (!function_exists('formatToIDR')) {
    function formatToIDR($number)
    {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }
}