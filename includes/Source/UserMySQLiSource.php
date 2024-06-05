<?php

/**
 * This file contains UserMySQLiSource interface.
 * php version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Source;

use ThoPHPAuthorization\Source\BasicUserMySQLiSource;
use ThoPHPAuthorization\Service\PhoneService;
use ThoPHPAuthorization\Service\MailService;
use ThoPHPAuthorization\User\UserInterface;
use ThoPHPAuthorization\User\User;

/**
 * UserMySQLiSource is a class, that contains basic methods to get/store/edit user in MySQL Database.
 */
class UserMySQLiSource extends BasicUserMySQLiSource
{
    /**
     * ${@inheritdoc}
     */
    public function getByIdentity($identity)
    {
        $esc_identity = $this->dbService->escape($identity);
        $where = [];
        if (User::$canIdentifyByName) {
            $where['name'] = "name = '{$esc_identity}'";
        }
        if (User::$canIdentifyByEmail) {
            $where['email'] = "email = '{$esc_identity}'";
        }
        if (User::$canIdentifyByPhone) {
            $where['phone'] = "phone = '{$esc_identity}'";
        }
        $result = $this->dbService->queryFirst("
            SELECT *
            FROM {$this->dbService->getTableName($this->tableName)}
            WHERE " . implode(' OR ', $where) . "
            LIMIT 1
        ");
        return $result ? $this->create($result) : null;
    }

    /**
     * Validate email.
     *
     * @param string $email - Phone number.
     *
     * @return boolean Email is valid or not.
     */
    public function validateEmail($email)
    {
        return MailService::validate($email);
    }

    /**
     * Validate phone number.
     *
     * @param string $phone - Phone number.
     *
     * @return boolean Phone number is valid or not.
     */
    public function validatePhone($phone)
    {
        return PhoneService::validate($phone);
    }

    /**
     * ${@inheritdoc}
     */
    public function validateData($data)
    {
        return parent::validateData($data)
            && isset($data['first_name']) && !empty($data['first_name'])
            && isset($data['last_name']) && !empty($data['last_name'])
            && isset($data['birthday']) && !empty($data['birthday'])
            && isset($data['email']) && $this->validateEmail($data['email'])
            && (!isset($data['phone']) || empty($data['phone']) || $this->validatePhone($data['phone']));
    }

    /**
     * ${@inheritdoc}
     */
    public function create($data)
    {
        return $this->validateData($data)
            ? new User($data)
            : null;
    }

    /**
     * ${@inheritdoc}
     */
    public function userExists(UserInterface &$user)
    {
        $where = [
            'name' => "name = '{$this->dbService->escape($user->getName())}'",
        ];
        if ($user->getID()) {
            $where['id'] = "id = '{$this->dbService->escape($user->getID())}'";
        }
        $email = $user->getEmail();
        if ($this->validateEmail($email)) {
            $where['email'] = "email = '{$this->dbService->escape($email)}'";
        }
        $phone = $user->getPhone();
        if ($this->validatePhone($phone)) {
            $where['phone'] = "phone = '{$this->dbService->escape($phone)}'";
        }
        $result = $this->dbService->queryFirst("
            SELECT *
            FROM {$this->dbService->getTableName($this->tableName)}
            WHERE " . implode(' OR ', $where) . "
            LIMIT 1
        ");
        return !!$result;
    }

    /**
     * ${@inheritdoc}
     */
    public function getStoreData(UserInterface &$user)
    {
        $data = parent::getStoreData($user);
        $data['first_name'] = $user->getFirstName();
        $data['last_name'] = $user->getLastName();
        $data['birthday'] = $user->getBirthday('Y-m-d');
        $data['email'] = $user->getEmail();
        $data['phone'] = $user->getPhone();
        $data['country'] = $user->getCountry();
        $data['state'] = $user->getState();
        $data['city'] = $user->getCity();
        $data['address'] = $user->getAddress();
        $data['zip'] = $user->getZIP();
        return $data;
    }

    /**
     * ${@inheritdoc}
     */
    public function editData(UserInterface &$user, $data = null)
    {
        // Set First Name.
        if (isset($data['first_name']) && !empty($data['first_name'])) {
            $user->setFirstName($data['first_name']);
        } elseif (isset($data['firstName']) && !empty($data['firstName'])) {
            $user->setFirstName($data['firstName']);
        }
        // Set Last Name.
        if (isset($data['last_name']) && !empty($data['last_name'])) {
            $user->setLastName($data['last_name']);
        } elseif (isset($data['lastName']) && !empty($data['lastName'])) {
            $user->setLastName($data['lastName']);
        }
        // Set Birthday.
        if (isset($data['birthday']) && !empty($data['birthday'])) {
            $user->setBirthday(
                $data['birthday'],
                isset($data['birthday_format'])
                    ? $data['birthday_format']
                    : (isset($data['birthdayFormat'])
                        ? $data['birthdayFormat']
                        : null)
            );
        }
        // Set email.
        if (isset($data['email']) && !empty($data['email'])) {
            $user->setEmail($data['email']);
        }
        // Set phone.
        if (isset($data['phone']) && !empty($data['phone'])) {
            $user->setPhone($data['phone']);
        }
        // Set country.
        if (isset($data['country']) && !empty($data['country'])) {
            $user->setCountry($data['country']);
        }
        // Set state.
        if (isset($data['state']) && !empty($data['state'])) {
            $user->setState($data['state']);
        }
        // Set city.
        if (isset($data['city']) && !empty($data['city'])) {
            $user->setCity($data['city']);
        }
        // Set address.
        if (isset($data['address']) && !empty($data['address'])) {
            $user->setAddress($data['address']);
        }
        // Set zip code.
        if (isset($data['zip']) && !empty($data['zip'])) {
            $user->setZip($data['zip']);
        }
        return parent::editData($user, $data);
    }
}
