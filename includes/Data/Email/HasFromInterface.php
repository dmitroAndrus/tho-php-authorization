<?php

/**
 * This file contains HasFromInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Email;

/**
 * HasFromInterface is an interface, it declares a possibility to access to the from email data.
 */
interface HasFromInterface
{
    /**
     * Set from email.
     *
     * @param string $email - From email.
     * @param string $name - From name.
     *
     * @return self.
     */
    public function setFrom($email, $name = null);

    /**
     * Has from.
     *
     * @return boolean.
     */
    public function hasFrom();

    /**
     * Get from.
     *
     * [
     *  'name' => 'Name',
     *  'email' => 'email@mail.com'
     * ]
     *
     * @return array.
     */
    public function getFrom();

    /**
     * Get from email.
     *
     * @return string.
     */
    public function getFromEmail();

    /**
     * Get from name.
     *
     * @return string.
     */
    public function getFromName();
}
