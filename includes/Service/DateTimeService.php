<?php

/**
 * This file contains DateTimeService class.
 * PHP version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Service;

/**
 * DateTimeService is a class, that contains methods to manipulate DateTimeInterface objects.
 */
class DateTimeService
{
    /**
     * Create DateTimeInterface object.
     *
     * Please check {@see https://www.php.net/manual/en/datetime.format.php} for format settings.
     *
     * @param string|DateTimeInterface $source Datetime source.
     * @param string $format Datetime format.
     * @param string|DateTimeZone $timezone Datetime time zone.
     *
     * @return DateTimeInterface|null
     */
    public static function create($source = null, $format = null, $timezone = null)
    {
        if ($source instanceof \DateTimeInterface) {
            // If it's already DateTimeInterface return it as it is.
            return $source;
        }
        if (is_null($source)) {
            // Return current datetime.
            return new \DateTime();
        }
        // Get time zone.
        $timezone = static::createTimeZone(is_null($timezone)
            ? date_default_timezone_get()
            : $timezone);
        if (is_integer($source)) {
            $datetime =  new \DateTime('@' . $source);
            $datetime->setTimezone($timezone);
            return $datetime;
        }
        if (is_string($source)) {
            // Try to parse datetime.
            try {
                if (!empty($format) && is_string($format)) {
                    $datetime = \DateTime::createFromFormat($format, $source, $timezone);
                } else {
                    $datetime = new \DateTime($source, $timezone);
                }
                return $datetime;
            } catch (Exception $e) {
                // Failed to parse datetime.
            }
        }
        return null;
    }
    /**
     * Get formated date and time string.
     *
     * Please check {@see https://www.php.net/manual/en/datetime.format.php} for format settings.
     *
     * @param DateTimeInterface $datetime Datetime object.
     * @param string $format Datetime format.
     *
     * @return string|null
     */
    public static function format(\DateTimeInterface $datetime, $format)
    {
        // Try to format datetime.
        try {
            if (!empty($format) && is_string($format)) {
                return $datetime->format($format);
            }
        } catch (Exception $e) {
            // Failed to format datetime.
        }
        return null;
    }

    /**
     * Create DateTimeZone object.
     *
     * Please check {@see https://www.php.net/manual/en/class.datetimezone.php} for more details.
     *
     * @param string|DateTimeZone $source Datetime zone source.
     *
     * @return DateTimeZone|null
     */
    public static function createTimeZone($source = null)
    {
        if ($source instanceof \DateTimeZone) {
            // If it's already DateTimeInterface return it as it is.
            return $source;
        }
        if (is_null($source)) {
            // Return current time zone.
            return new \DateTimeZone(date_default_timezone_get());
        }
        if (is_string($source)) {
            // Try to parse datetime.
            try {
                return new \DateTimeZone($source);
            } catch (Exception $e) {
                // Failed to parse datetime.
            }
        }
        return null;
    }
}
