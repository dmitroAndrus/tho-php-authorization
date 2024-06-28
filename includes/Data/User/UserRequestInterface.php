<?php

/**
 * User request interface.
 * PHP version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\User;

use ThoPHPAuthorization\Data\ID\HasIDInterface;
use ThoPHPAuthorization\Data\User\HasUserInterface;
use ThoPHPAuthorization\Data\Password\HasSecurityKeyInterface;
use ThoPHPAuthorization\Data\DateTime\HasCreatedInterface;
use ThoPHPAuthorization\Data\DateTime\HasValidUntilInterface;

/**
 * User request interface to define basic user request related methods.
 */
interface UserRequestInterface extends
    HasIDInterface,
    HasUserInterface,
    HasSecurityKeyInterface,
    HasCreatedInterface,
    HasValidUntilInterface
{
    /**
     * Check if request expired.
     *
     * @return boolean
     */
    public function expired();
}
