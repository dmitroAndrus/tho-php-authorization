<?php

/**
 * This file contains UserAccessSourceInterface interface.
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
use ThoPHPAuthorization\Data\User\UserRequestInterface;

/**
 * UserAccessSourceInterface is an interface, it declares a possibility to work with user access request.
 *
 * Used to provide simple access to user with by creating user request.
 */
interface UserAccessSourceInterface
{
    /**
     * Get user request by security key.
     *
     * @param string $security Security key.
     *
     * @return UserRequestInterface|null
     */
    public function getBySecurity($security);

    /**
     * Create user request.
     *
     * @param UserInterface $user User object.
     * @param mixed $data Request data.
     *
     * @return UserRequestInterface|null
     */
    public function create(UserInterface $user, $data = null);

    /**
     * Resolve user request.
     *
     * @param UserRequestInterface $request Request to resolve.
     * @param mixed $data Necessary data to resolve request.
     *
     * @return boolean
     */
    public function resolve(UserRequestInterface $request, $data = null);
}
