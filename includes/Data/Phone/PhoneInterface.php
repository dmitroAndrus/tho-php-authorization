<?php

/**
 * This file contains PhoneInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Phone;

use ThoPHPAuthorization\Data\Phone\HasPhoneInterface;

/**
 * PhoneInterface is an interface to maintain and manipulate phone data.
 */
interface PhoneInterface extends HasPhoneInterface
{
    /**
     * Set phone type.
     *
     * Type of phone: mobile, fax, work phone, etc.
     *
     * @param string $type - Phone type.
     *
     * @return self.
     */
    public function setPhoneType($type);

    /**
     * Get phone type.
     *
     * Type of phone: home, mobile, fax, work phone, etc.
     *
     * @return string.
     */
    public function getPhoneType();

    /**
     * Check phone type.
     *
     * Type of phone: mobile, fax, work phone, etc.
     *
     * @param string $type - Phone type.
     *
     * @return boolean.
     */
    public function isPhoneType($type);
}
