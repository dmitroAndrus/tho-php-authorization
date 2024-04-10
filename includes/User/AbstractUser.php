<?php

/**
 * This file contains AbstractUser class.
 * PHP version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\User;

use ThoPHPAuthorization\User\UserInterface;

/**
 * AbstractUser is an abstract class that provides simple user authorization functionality.
 */
abstract class AbstractUser implements UserInterface
{
    /**
     * {@inheritdoc}
     */
    public function canAuthorize($identity, $security)
    {
        return $this->checkIdentity($identity) && $this->checkSecurity($security);
    }
}
