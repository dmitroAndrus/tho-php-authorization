<?php

/**
 * This file contains BasicUser class.
 * PHP version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\User;

use ThoPHPAuthorization\User\BasicUser;
use ThoPHPAuthorization\Data\Name\HasFirstLastNameInterface;
use ThoPHPAuthorization\Data\Name\FirstLastNameTrait;
use ThoPHPAuthorization\Data\Email\HasEmailInterface;
use ThoPHPAuthorization\Data\Email\EmailTrait;
use ThoPHPAuthorization\Data\Phone\HasPhoneInterface;
use ThoPHPAuthorization\Data\Phone\PhoneTrait;
use ThoPHPAuthorization\Data\Address\HasAddressInterface;
use ThoPHPAuthorization\Data\Address\AddressTrait;

/**
 * BasicUser is an class that provides all basic User data.
 */
class User extends BasicUser implements HasFirstLastNameInterface, HasEmailInterface, HasPhoneInterface, HasAddressInterface
{
    use FirstLastNameTrait;
    use EmailTrait;
    use PhoneTrait;
    use AddressTrait;

    /**
     * Can identify by name.
     *
     * @var boolean
     */
    public static $canIdentifyByName = true;

    /**
     * Can identify by email.
     *
     * @var boolean
     */
    public static $canIdentifyByEmail = true;

    /**
     * Can identify by phone number.
     *
     * @var boolean
     */
    public static $canIdentifyByPhone = true;

    /**
     * {@inheritdoc}
     */
    public function checkIdentity($identity)
    {
        return (static::$canIdentifyByName && $this->getName() === $identity)
            || (static::$canIdentifyByEmail && $this->getEmail() === $identity)
            || (static::$canIdentifyByPhone && $this->getPhone() === $identity);
    }
}
