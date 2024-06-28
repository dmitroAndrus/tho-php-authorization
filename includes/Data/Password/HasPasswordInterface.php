<?php

/**
 * This file contains HasPasswordInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Password;

/**
 * HasPasswordInterface is an interface, it declares password protection.
 */
interface HasPasswordInterface
{
    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword();

    /**
     * Encrypt password.
     *
     * @param string $password Password.
     *
     * @return string
     */
    public function encryptPassword($password);

    /**
     * Set password.
     *
     * @param string $password Password.
     * @param boolean $encrypt Encrypt password.
     *
     * @return self
     */
    public function setPassword($password, $encrypt = true);

    /**
     * Check password.
     *
     * @param $password Password.
     *
     * @return boolean Passed or not password check.
     */
    public function checkPassword($password);
}
