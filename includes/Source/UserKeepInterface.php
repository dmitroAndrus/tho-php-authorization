<?php

/**
 * This file contains UserKeepInterface interface.
 * php version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Source;

use ThoPHPAuthorization\User\UserInterface;

/**
 * UserKeepInterface is an interface, it declares a possibility to keep users signed in by all means.
 */
interface UserKeepInterface
{
    /**
     * Keep user.
     *
     * @param UserInterface $user User object.
     * @param DateTime|timestamp $valid_until Date and time until it should be valid.
     * @param string $name Unique name.
     *
     * @return string|boolean Security key or false, when failed to keep.
     */
    public function keep(UserInterface $user, $valid_until, $name = null);

    /**
     * Restore keeped user.
     *
     * @param string $security Security key to keep the user.
     *
     * @return UserInterface|null
     */
    public function restoreKeeped($security);

    /**
     * Release keeped user.
     *
     * @param string $security Security key to keep the user.
     *
     * @return boolean
     */
    public function releaseKeeped($security);
}
