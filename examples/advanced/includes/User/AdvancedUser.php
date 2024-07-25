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

namespace ThoPHPAuthorizationExample\User;

use ThoPHPAuthorization\User\BasicUser;
use ThoPHPAuthorization\Data\Name\HasFirstLastNameInterface;
use ThoPHPAuthorization\Data\Name\FirstLastNameTrait;
use ThoPHPAuthorization\Data\Email\HasEmailInterface;
use ThoPHPAuthorization\Data\Email\EmailTrait;
use ThoPHPAuthorization\Data\Email\HasEmailsInterface;
use ThoPHPAuthorization\Data\Email\EmailsTrait;
use ThoPHPAuthorization\Data\Phone\HasPhoneInterface;
use ThoPHPAuthorization\Data\Phone\PhoneTrait;
use ThoPHPAuthorization\Data\Phone\HasPhonesInterface;
use ThoPHPAuthorization\Data\Phone\PhonesTrait;
use ThoPHPAuthorization\Data\DateTime\HasBirthdayInterface;
use ThoPHPAuthorization\Data\DateTime\BirthdayTrait;
use ThoPHPAuthorization\Data\Address\HasAddressesInterface;
use ThoPHPAuthorization\Data\Address\AddressesTrait;
use ThoPHPAuthorization\Data\User\UserAddress;
use ThoPHPAuthorization\Data\LazyLoad\LazyLoadTrait;

/**
 * User is an class that provides all basic User data.
 */
class AdvancedUser extends BasicUser implements
    HasFirstLastNameInterface,
    HasEmailInterface,
    HasPhoneInterface,
    HasBirthdayInterface,
    HasEmailsInterface,
    HasPhonesInterface,
    HasAddressesInterface
{
    use FirstLastNameTrait;
    use EmailTrait;
    use PhoneTrait;
    use BirthdayTrait;
    use EmailsTrait {
        setEmails as protected setDirectEmails;
        getEmails as protected getDirectEmails;
    }
    use PhonesTrait {
        setPhones as protected setDirectPhones;
        getPhones as protected getDirectPhones;
    }
    use AddressesTrait {
        setAddresses as protected setDirectAddresses;
        getAddresses as protected getDirectAddresses;
    }
    use LazyLoadTrait;

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
        // Set additional emails.
        if (isset($data['emails'])) {
            $this->setEmails($data['emails']);
        }
        // Set additional phones.
        if (isset($data['phones'])) {
            $this->setPhones($data['phones']);
        }
        // Set additional addresses.
        if (isset($data['addresses'])) {
            $this->setAddresses($data['addresses']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function checkIdentity($identity)
    {
        return ($this->getName() === $identity)
            || ($this->getEmail() === $identity)
            || ($this->getPhone() === $identity);
    }

    /**
     * {@inheritdoc}
     */
    public function setEmails($emails)
    {
        // Try to add lazy load.
        if (!$this->addLazyLoad('emails', $emails)) {
            $this->removeLazyLoad('emails');
            $this->setDirectEmails($emails);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmails()
    {
        // If there is laze load - load property data.
        if ($this->hasLazyLoad('emails')) {
            $emails = $this->runLazyLoad('emails');
            $this->addEmails($emails);
        }
        return $this->getDirectEmails();
    }

    /**
     * {@inheritdoc}
     */
    public function setPhones($phones)
    {
        // Try to add lazy load.
        if (!$this->addLazyLoad('phones', $phones)) {
            $this->removeLazyLoad('phones');
            $this->setDirectPhones($phones);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhones()
    {
        // If there is laze load - load property data.
        if ($this->hasLazyLoad('phones')) {
            $phones = $this->runLazyLoad('phones');
            $this->addPhones($phones);
        }
        return $this->getDirectPhones();
    }

    /**
     * {@inheritdoc}
     */
    public function setAddresses($addresses)
    {
        // Try to add lazy load.
        if (!$this->addLazyLoad('addresses', $addresses)) {
            $this->removeLazyLoad('addresses');
            $this->setDirectAddresses($addresses);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAddresses()
    {
        // If there is laze load - load property data.
        if ($this->hasLazyLoad('addresses')) {
            $addresses = $this->runLazyLoad('addresses');
            $this->addAddresses($addresses);
        }
        return $this->getDirectAddresses();
    }
}
