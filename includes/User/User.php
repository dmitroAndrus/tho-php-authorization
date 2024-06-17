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
use ThoPHPAuthorization\Data\DateTime\HasBirthdayInterface;
use ThoPHPAuthorization\Data\DateTime\BirthdayTrait;

/**
 * BasicUser is an class that provides all basic User data.
 */
class User extends BasicUser implements
    HasFirstLastNameInterface,
    HasEmailInterface,
    HasPhoneInterface,
    HasAddressInterface,
    HasBirthdayInterface
{
    use FirstLastNameTrait;
    use EmailTrait;
    use PhoneTrait;
    use AddressTrait;
    use BirthdayTrait;

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
    public static $canIdentifyByPhone = false;

    /**
     * Constructor.
     *
     * @param array $data User data.
     *
     * @return void
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        // Set First name.
        if (isset($data['first_name']) && !empty($data['first_name'])) {
            $this->setFirstName($data['first_name']);
        } elseif (isset($data['firstName']) && !empty($data['firstName'])) {
            $this->setFirstName($data['firstName']);
        }
        // Set Last name.
        if (isset($data['last_name']) && !empty($data['last_name'])) {
            $this->setLastName($data['last_name']);
        } elseif (isset($data['lastName']) && !empty($data['lastName'])) {
            $this->setFirstName($data['lastName']);
        }
        // Set Email.
        if (isset($data['email']) && !empty($data['email'])) {
            $this->setEmail($data['email']);
        }
        // Set Phone.
        if (isset($data['phone']) && !empty($data['phone'])) {
            $this->setPhone($data['phone']);
        }
        // Set Country.
        if (isset($data['country']) && !empty($data['country'])) {
            $this->setCountry($data['country']);
        }
        // Set State.
        if (isset($data['state']) && !empty($data['state'])) {
            $this->setState($data['state']);
        }
        // Set City.
        if (isset($data['city']) && !empty($data['city'])) {
            $this->setCity($data['city']);
        }
        // Set Address.
        if (isset($data['address']) && !empty($data['address'])) {
            $this->setAddress($data['address']);
        }
        // Set ZIP.
        if (isset($data['zip']) && !empty($data['zip'])) {
            $this->setZIP($data['zip']);
        }
        // Set Birthday.
        if (isset($data['birthday']) && !empty($data['birthday'])) {
            $this->setBirthday(
                $data['birthday'],
                isset($data['birthday_format'])
                    ? $data['birthday_format']
                    : (isset($data['birthdayFormat'])
                        ? $data['birthdayFormat']
                        : null)
            );
        }
    }

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
