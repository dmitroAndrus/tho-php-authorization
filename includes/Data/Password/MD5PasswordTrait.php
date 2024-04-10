<?php

/**
 * This file contains MD5PasswordTrait trait.
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
 * MD5PasswordTrait is a trait, it contains basic methods to manipulate password data.
 *
 * Encrypt password with MD5.
 */
trait MD5PasswordTrait
{
    use PasswordTrait;

    /**
     * Encrypt password with MD5.
     *
     * @param string $password - Password.
     *
     * @return string.
     */
    public function encryptPassword($password)
    {
        return md5($password);
    }
}
