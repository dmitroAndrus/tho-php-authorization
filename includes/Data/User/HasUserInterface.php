<?php

/**
 * This file contains HasUserInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\User;

use ThoPHPAuthorization\User\UserInterface;

/**
 * HasUserInterface is an interface, it declares a possibility to access to user object.
 */
interface HasUserInterface
{
    /**
     * Set user.
     *
     * User that is connected to the request.
     *
     * @param UserInterface $user User.
     *
     * @return self
     */
    public function setUser(UserInterface $user);

    /**
     * Get user.
     *
     * User that is connected to the request.
     *
     * @return UserInterface
     */
    public function getUser();
}
