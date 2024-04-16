<?php

/**
 * This file contains PasswordTrait trait.
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
 * PasswordTrait is a trait, it contains basic methods to manipulate password data.
 *
 * Implements everything from ThoPHPAuthorization\Data\Password\HasPasswordInterface.
 */
trait PasswordTrait
{
    /**
     * Password.
     *
     * @var string
     */
    protected $password;

    /**
     * Get password.
     *
     * @return string.
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Encrypt password.
     *
     * @param string $password - Password.
     *
     * @return string.
     */
    public function encryptPassword($password)
    {
        return $password;
    }

    /**
     * Set password.
     *
     * @param string $password - Password.
     * @param boolean $encrypt - Encrypt password.
     *
     * @return self.
     */
    public function setPassword($password, $encrypt = true)
    {
        $this->password = $encrypt
            ? $this->encryptPassword($password)
            : $password;
        return $this;
    }

    /**
     * Check password.
     *
     * @param $password - Password.
     *
     * @return boolen Passed or not password check.
     */
    public function checkPassword($password)
    {
        return $this->getPassword() === $this->encryptPassword($password);
    }
}
