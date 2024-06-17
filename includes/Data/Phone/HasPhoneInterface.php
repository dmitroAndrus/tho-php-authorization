<?php

/**
 * This file contains HasPhoneInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Phone;

/**
 * HasPhoneInterface is an interface, it declares a possibility to access to the phone data.
 */
interface HasPhoneInterface
{
    /**
     * Set phone.
     *
     * @param string $phone Phone.
     *
     * @return self
     */
    public function setPhone($phone);

    /**
     * Get phone.
     *
     * @return string
     */
    public function getPhone();
}
