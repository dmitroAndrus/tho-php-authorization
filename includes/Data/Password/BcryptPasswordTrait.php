<?php

/**
 * This file contains BcryptPasswordTrait trait.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Password;

use ThoPHPAuthorization\Data\Password\PasswordTrait;

/**
 * BcryptPasswordTrait is a trait, it contains basic methods to manipulate password data.
 *
 * Encrypt password with BCRYPT.
 */
trait BcryptPasswordTrait
{
    use PasswordTrait;

    /**
     * Encrypt password with MD5.
     *
     * @param string $password Password.
     *
     * @return string
     */
    public function encryptPassword($password)
    {
        $opts = [];
        if (isset(static::$BcryptCost)) {
            $opts['cost'] = static::$BcryptCost;
        }
        return password_hash($password, PASSWORD_BCRYPT, $opts);
    }

    /**
     * Check password.
     *
     * @param $password Password.
     *
     * @return boolean Passed or not password check.
     */
    public function checkPassword($password)
    {
        return password_verify($password, $this->getPassword());
    }
}
