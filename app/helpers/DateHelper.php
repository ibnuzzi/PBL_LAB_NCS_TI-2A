<?php
/**
 * Date Helper Functions
 * 
 * Utility functions for date formatting and manipulation
 */

class DateHelper
{
    /**
     * Format date to Indonesian format
     * 
     * @param string $date Date string (Y-m-d or datetime)
     * @param string $format Format pattern (optional)
     *                        'short' = "12 Jan 2025"
     *                        'long' = "12 Januari 2025"
     *                        'full' = "Senin, 12 Januari 2025"
     * @return string Formatted date in Indonesian
     */
    public static function toIndonesianDate($date, $format = 'long')
    {
        if (empty($date) || $date === '0000-00-00' || $date === '0000-00-00 00:00:00') {
            return '-';
        }

        $timestamp = strtotime($date);
        if ($timestamp === false) {
            return '-';
        }

        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $days = [
            'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
        ];

        $day = (int)date('d', $timestamp);
        $month = (int)date('m', $timestamp) - 1;
        $year = date('Y', $timestamp);
        $dayOfWeek = (int)date('w', $timestamp);

        switch ($format) {
            case 'short':
                return $day . ' ' . substr($months[$month], 0, 3) . ' ' . $year;
            case 'full':
                return $days[$dayOfWeek] . ', ' . $day . ' ' . $months[$month] . ' ' . $year;
            case 'long':
            default:
                return $day . ' ' . $months[$month] . ' ' . $year;
        }
    }

    /**
     * Get Indonesian month name
     * 
     * @param int $month Month number (1-12)
     * @return string Indonesian month name
     */
    public static function getIndonesianMonth($month)
    {
        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        return isset($months[$month - 1]) ? $months[$month - 1] : '';
    }

    /**
     * Get Indonesian day name
     * 
     * @param string $date Date string
     * @return string Indonesian day name
     */
    public static function getIndonesianDayName($date)
    {
        $days = [
            'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
        ];
        $timestamp = strtotime($date);
        if ($timestamp === false) {
            return '';
        }
        $dayIndex = (int)date('w', $timestamp);
        return $days[$dayIndex];
    }
}
