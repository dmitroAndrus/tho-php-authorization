<?php

/**
 * This file contains UserForgotPasswordRequest class.
 * PHP version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\User;

use ThoPHPAuthorization\Data\User\AbstractUserRequest;

/**
 * UserForgotPasswordRequest is a class that provides access to user forgot password requests.
 */
final class UserForgotPasswordRequest extends AbstractUserRequest
{
    /**
     * User request type.
     *
     * @var string
     */
    public const TYPE = 'forgot_password';
}
