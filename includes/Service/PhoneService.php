<?php

/**
 * This file contains PhoneService class.
 * PHP version 7.4
 *
 * @category Service
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Service;

/**
 * PhoneService is a class, that contains methods related to phone number.
 */
class PhoneService
{
    /**
     * Validate generic phone number.
     *
     * Regexp taken from https://stackoverflow.com/a/20971688/23252561
     * Matches:
     *  - (+351) 282 43 50 50
     *  - 90191919908
     *  - 555-8909
     *  - 001 6867684
     *  - 001 6867684x1
     *  - 1 (234) 567-8901
     *  - 1-234-567-8901 x1234
     *  - 1-234-567-8901 ext1234
     *  - 1-234 567.89/01 ext.1234
     *  - 1(234)5678901x1234
     *  - (123)8575973
     *  - (0055)(123)8575973
     *  - +1 282 282 2828
     *
     * @param string $phone - Phone number.
     *
     * @return boolean Phone number is valid or not.
     */
    public static function validate($phone)
    {
        $regexp = "/^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d*)\)?)[\-\.\ \\\\\\/]?)?"
            . "((?:\\(?\\d{1,}\\)?[\\-\\.\\ \\\\\\/]?)+)"
            . "(?:[\\-\\.\\ \\\\\\/]?(?:#|ext\\.?|extension|x)[\\-\\.\\ \\\\\\/]?(\\d+))?$/i";
        return is_string($phone) && !empty($phone)
            && preg_match($regexp, $phone);
    }
}
