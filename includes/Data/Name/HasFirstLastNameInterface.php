<?php

/**
 * This file contains HasFirstLastNameInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Name;

/**
 * HasFirstLastNameInterface is an interface, it declares a possibility to access to the first and last name data.
 */
interface HasFirstLastNameInterface
{
    /**
     * Set first name.
     *
     * @param string $firstName First name.
     *
     * @return self
     */
    public function setFirstName($firstName);

    /**
     * Get first name.
     *
     * @return string
     */
    public function getFirstName();

    /**
     * Set last name.
     *
     * @param string $lastName Last name.
     *
     * @return self
     */
    public function setLastName($lastName);

    /**
     * Get last name.
     *
     * @return string
     */
    public function getLastName();

    /**
     * Get formated name data.
     *
     * @param string $format Name format.
     *
     * @return string
     */
    public function getFormatedName($format);

    /**
     * Get full name.
     *
     * @return string
     */
    public function getFullName();
}
