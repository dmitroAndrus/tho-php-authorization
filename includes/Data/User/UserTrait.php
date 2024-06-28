<?php

/**
 * This file contains UserTrait trait.
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
 * UserTrait is a trait, it contains basic methods to provide acccess to user object.
 *
 * Implements everything from {@see \ThoPHPAuthorization\Data\User\HasUserInterface}.
 */
trait UserTrait
{
    /**
     * User.
     *
     * @var UserInterface
     */
    protected $user;

    /**
     * Set user.
     *
     * User that is connected to the request.
     *
     * @param UserInterface $user User.
     *
     * @return self
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user.
     *
     * User that is connected to the request.
     *
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
}
