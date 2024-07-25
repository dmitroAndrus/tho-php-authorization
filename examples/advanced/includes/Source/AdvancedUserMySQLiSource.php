<?php

/**
 * This file contains AdvancedUserMySQLiSource interface.
 * php version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorizationExample
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorizationExample\Source;

use ThoPHPAuthorization\Source\BasicUserMySQLiSource;
use ThoPHPAuthorization\Service\PhoneService;
use ThoPHPAuthorization\Service\MailService;
use ThoPHPAuthorization\User\UserInterface;
use ThoPHPAuthorizationExample\User\AdvancedUser;
use ThoPHPAuthorization\Data\User\UserEmail;
use ThoPHPAuthorization\Data\User\UserPhone;
use ThoPHPAuthorization\Data\User\UserAddress;

/**
 * AdvancedUserMySQLiSource is a class, that contains methods to get/store/edit user in MySQL Database.
 */
class AdvancedUserMySQLiSource extends BasicUserMySQLiSource
{
    /**
     * User emails table name.
     *
     * @var string
     */
    protected $emailsTableName = 'user_email';

    /**
     * User phones table name.
     *
     * @var string
     */
    protected $phonesTableName = 'user_phone';

    /**
     * User addresses table name.
     *
     * @var string
     */
    protected $addressesTableName = 'user_address';

    /**
     * {@inheritdoc}
     */
    public function getByIdentity($identity)
    {
        $esc_identity = $this->dbService->escape($identity);
        $where = [];
        $where['name'] = "name = '{$esc_identity}'";
        $where['email'] = "email = '{$esc_identity}'";
        $where['phone'] = "phone = '{$esc_identity}'";
        $result = $this->dbService->queryFirst("
            SELECT *
            FROM {$this->dbService->getTableName($this->tableName)}
            WHERE " . implode(' OR ', $where) . "
            LIMIT 1
        ");
        return $result ? $this->create($result) : null;
    }

    /**
     * Get user by email.
     *
     * @param string $email Phone number.
     *
     * @return UserInterface|null
     */
    public function getByEmail($email)
    {
        $esc_email = $this->dbService->escape($email);
        $result = $this->dbService->queryFirst("
            SELECT *
            FROM {$this->dbService->getTableName($this->tableName)}
            WHERE email = '{$esc_email}'
            LIMIT 1
        ");
        return $result ? $this->create($result) : null;
    }

    /**
     * Get user emails.
     *
     * @param UserInterface|mixed $user User object or user id.
     *
     * @return UserEmail[]|null
     */
    public function getUserEmails($user)
    {
        $esc_id = $user instanceof UserInterface
            ? $user->getID()
            : $this->dbService->escape($user);
        $result = $this->dbService->queryAll("
            SELECT *
            FROM {$this->dbService->getTableName($this->emailsTableName)}
            WHERE user_id = '{$esc_id}'
        ");
        return $result ? $this->createUserEmails($result) : null;
    }

    /**
     * Get user phones.
     *
     * @param UserInterface|mixed $user User object or user id.
     *
     * @return UserPhone[]|null
     */
    public function getUserPhones($user)
    {
        $esc_id = $user instanceof UserInterface
            ? $user->getID()
            : $this->dbService->escape($user);
        $result = $this->dbService->queryAll("
            SELECT *
            FROM {$this->dbService->getTableName($this->phonesTableName)}
            WHERE user_id = '{$esc_id}'
        ");
        return $result ? $this->createUserPhones($result) : null;
    }

    /**
     * Get user addresses.
     *
     * @param UserInterface|mixed $user User object or user id.
     *
     * @return UserPhone[]|null
     */
    public function getUserAddresses($user)
    {
        $esc_id = $user instanceof UserInterface
            ? $user->getID()
            : $this->dbService->escape($user);
        $result = $this->dbService->queryAll("
            SELECT *
            FROM {$this->dbService->getTableName($this->addressesTableName)}
            WHERE user_id = '{$esc_id}'
        ");
        return $result ? $this->createUserAddresses($result) : null;
    }

    /**
     * Validate email.
     *
     * @param string $email Email address.
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
     * @param string $phone Phone number.
     *
     * @return boolean Phone number is valid or not.
     */
    public function validatePhone($phone)
    {
        return PhoneService::validate($phone);
    }

    /**
     * {@inheritdoc}
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
     * Create user emails.
     *
     * @param array $data User emails data.
     *
     * @return UserEmail[]|null
     */
    public function createUserEmails($data)
    {
        $items = [];
        if (is_array($data)) {
            foreach ($data as $item_data) {
                if ($item_data instanceof UserEmail) {
                    $items[] = $item_data;
                } elseif (is_array($item_data)) {
                    $items[] = new UserEmail($item_data);
                }
            }
        }
        return empty($items) ? null : $items;
    }

    /**
     * Create user phones.
     *
     * @param array $data User phones data.
     *
     * @return UserPhone[]|null
     */
    public function createUserPhones($data)
    {
        $items = [];
        if (is_array($data)) {
            foreach ($data as $item_data) {
                if ($item_data instanceof UserPhone) {
                    $items[] = $item_data;
                } elseif (is_array($item_data)) {
                    $items[] = new UserPhone($item_data);
                }
            }
        }
        return empty($items) ? null : $items;
    }

    /**
     * Create user addresses.
     *
     * @param array $data User addresses data.
     *
     * @return UserAddress[]|null
     */
    public function createUserAddresses($data)
    {
        $items = [];
        if (is_array($data)) {
            foreach ($data as $item_data) {
                if ($item_data instanceof UserAddress) {
                    $items[] = $item_data;
                } elseif (is_array($item_data)) {
                    $items[] = new UserAddress($item_data);
                }
            }
        }
        return empty($items) ? null : $items;
    }

    /**
     * {@inheritdoc}
     */
    public function create($data)
    {
        if ($this->validateData($data)) {
            $source = $this;
            $data['emails'] = isset($data['emails'])
                ? $this->createUserEmails($data['emails'])
                : function ($obj) use ($source) {
                    return $source->getUserEmails($obj);
                };
            $data['phones'] = isset($data['phones'])
                ? $this->createUserPhones($data['phones'])
                : function ($obj) use ($source) {
                    return $source->getUserPhones($obj);
                };
            $data['addresses'] = isset($data['addresses'])
                ? $this->createUserAddresses($data['addresses'])
                : function ($obj) use ($source) {
                    return $source->getUserAddresses($obj);
                };
            return new AdvancedUser($data);
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function userExists(UserInterface $user)
    {
        $user_id = $user->getID();
        $where = [
            'name' => "name = '{$this->dbService->escape($user->getName())}'",
        ];
        if ($user_id) {
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
     * {@inheritdoc}
     */
    public function userUnique(UserInterface $user, $data = null)
    {
        $name = $user->getName();
        $email = $user->getEmail();
        $phone = $user->getPhone();
        if (is_array($data)) {
            if (isset($data['name'])) {
                $name = $data['name'];
            }
            if (isset($data['email'])) {
                $email = $data['email'];
            }
            if (isset($data['phone'])) {
                $phone = $data['phone'];
            }
        }
        $where = [
            'name' => "name = '{$this->dbService->escape($name)}'",
        ];
        if ($this->validateEmail($email)) {
            $where['email'] = "email = '{$this->dbService->escape($email)}'";
        }
        if ($this->validatePhone($phone)) {
            $where['phone'] = "phone = '{$this->dbService->escape($phone)}'";
        }
        $where_str = implode(' OR ', $where);
        $user_id = $user->getID();
        if ($user_id) {
            $where_str = "id <> '{$user_id}' AND ({$where_str})";
        }
        $result = $this->dbService->queryFirst("
            SELECT *
            FROM {$this->dbService->getTableName($this->tableName)}
            WHERE {$where_str}
            LIMIT 1
        ");
        return !$result;
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreData(UserInterface &$user)
    {
        $data = parent::getStoreData($user);
        $data['first_name'] = $user->getFirstName();
        $data['last_name'] = $user->getLastName();
        $data['birthday'] = $user->getBirthday('Y-m-d');
        $data['email'] = $user->getEmail();
        $data['phone'] = $user->getPhone();
        $data['emails'] = [];
        $items = $user->getEmails();
        if (!empty($items)) {
            foreach ($items as $item) {
                $item_data = [
                    'type' => $item->getType(),
                    'email' => $item->getEmail()
                ];
                if ($item->getID()) {
                    $item_data['id'] = $item->getID();
                }
                $data['emails'][] = $item_data;
            }
        }
        $data['phones'] = [];
        $items = $user->getPhones();
        if (!empty($items)) {
            foreach ($items as $item) {
                $item_data = [
                    'type' => $item->getType(),
                    'phone' => $item->getPhone()
                ];
                if ($item->getID()) {
                    $item_data['id'] = $item->getID();
                }
                $data['phones'][] = $item_data;
            }
        }
        $data['addresses'] = [];
        $items = $user->getAddresses();
        if (!empty($items)) {
            foreach ($items as $item) {
                $item_data = [
                    'type' => $item->getType(),
                    'country' => $item->getCountry(),
                    'state' => $item->getState(),
                    'city' => $item->getCity(),
                    'address' => $item->getAddress(),
                    'zip' => $item->getZIP()
                ];
                if ($item->getID()) {
                    $item_data['id'] = $item->getID();
                }
                $data['addresses'][] = $item_data;
            }
        }
        return $data;
    }

    /**
     * {@inheritdoc}
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
        $source = $this;
        // Set additional emails.
        $user->setEmails(
            isset($data['emails'])
                ? $this->createUserEmails($data['emails'])
                : function ($obj) use ($source) {
                    return $source->getUserEmails($obj);
                }
        );
        // Set additional phones.
        $user->setPhones(
            isset($data['phones'])
                ? $this->createUserPhones($data['phones'])
                : function ($obj) use ($source) {
                    return $source->getUserPhones($obj);
                }
        );
        // Set additional addresses.
        $user->setAddresses(
            isset($data['addresses'])
                ? $this->createUserAddresses($data['addresses'])
                : function ($obj) use ($source) {
                    return $source->getUserAddresses($obj);
                }
        );
        return parent::editData($user, $data);
    }

    /**
     * Insert user emails data to database.
     *
     * @param mixed $id User id.
     * @param array $data User emails data.
     * @param boolean $cleanup Cleanup/remove old emails from database.
     *
     * @return boolean Successful or not.
     */
    public function insertEmails($id, $data, $cleanup = false)
    {
        $result = true;
        // Cleanup old emails.
        if ($cleanup) {
            $this->dbService->removeById($this->emailsTableName, $id, 'user_id');
        }
        // Insert emails.
        if ($data) {
            foreach ($data as $item) {
                $item['user_id'] = $id;
                $result = $result && $this->dbService->insert($this->emailsTableName, $item);
            }
        }
        return $result;
    }

    /**
     * Insert user phones data to database.
     *
     * @param mixed $id User id.
     * @param array $data User phones data.
     * @param boolean $cleanup Cleanup/remove old phones from database.
     *
     * @return boolean Successful or not.
     */
    public function insertPhones($id, $data, $cleanup = false)
    {
        $result = true;
        // Cleanup old phones.
        if ($cleanup) {
            $this->dbService->removeById($this->phonesTableName, $id, 'user_id');
        }
        // Insert phones.
        if ($data) {
            foreach ($data as $item) {
                $item['user_id'] = $id;
                $result = $result && $this->dbService->insert($this->phonesTableName, $item);
            }
        }
        return $result;
    }

    /**
     * Insert user addresses data to database.
     *
     * @param mixed $id User id.
     * @param array $data User addresses data.
     * @param boolean $cleanup Cleanup/remove old addresses from database.
     *
     * @return boolean Successful or not.
     */
    public function insertAddresses($id, $data, $cleanup = false)
    {
        $result = true;
        // Cleanup old addresses.
        if ($cleanup) {
            $this->dbService->removeById($this->addressesTableName, $id, 'user_id');
        }
        // Insert addresses.
        if ($data) {
            foreach ($data as $item) {
                $item['user_id'] = $id;
                $result = $result && $this->dbService->insert($this->addressesTableName, $item);
            }
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    protected function insert($data)
    {
        $emails = null;
        $phones = null;
        $addresses = null;
        if (isset($data['emails'])) {
            $emails = $data['emails'];
            unset($data['emails']);
        }
        if (isset($data['phones'])) {
            $phones = $data['phones'];
            unset($data['phones']);
        }
        if (isset($data['addresses'])) {
            $addresses = $data['addresses'];
            unset($data['addresses']);
        }
        /* Tell mysqli to throw an exception if an error occurs */
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        /* Start transaction */
        $this->dbService->startTransaction();
        $result = true;
        try {
            parent::insert($data);
            // Insert additional data.
            $user_id = $this->insertedUserID;
            if (is_array($emails)) {
                $this->insertEmails($user_id, $emails);
            }
            if (is_array($phones)) {
                $this->insertPhones($user_id, $phones);
            }
            if (is_array($addresses)) {
                $this->insertAddresses($user_id, $addresses);
            }
            $this->dbService->commit();
        } catch (mysqli_sql_exception $exception) {
            $this->dbService->rollback();
            $result = false;
        }
        /* Tell mysqli to stop throwing exceptions */
        mysqli_report(MYSQLI_REPORT_OFF);
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    protected function update($id, $data)
    {
        $emails = null;
        $phones = null;
        $addresses = null;
        if (isset($data['emails'])) {
            $emails = $data['emails'];
            unset($data['emails']);
        }
        if (isset($data['phones'])) {
            $phones = $data['phones'];
            unset($data['phones']);
        }
        if (isset($data['addresses'])) {
            $addresses = $data['addresses'];
            unset($data['addresses']);
        }
        /* Tell mysqli to throw an exception if an error occurs */
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        /* Start transaction */
        $this->dbService->startTransaction();
        $result = true;
        try {
            parent::update($id, $data);
            // Insert additional data.
            $this->insertEmails($id, $emails, true);
            $this->insertPhones($id, $phones, true);
            $this->insertAddresses($id, $addresses, true);
            $this->dbService->commit();
        } catch (mysqli_sql_exception $exception) {
            $this->dbService->rollback();
            $result = false;
        }
        /* Tell mysqli to stop throwing exceptions */
        mysqli_report(MYSQLI_REPORT_OFF);
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($user)
    {
        $user_id = $user->getID();
        /* Tell mysqli to throw an exception if an error occurs */
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        /* Start transaction */
        $this->dbService->startTransaction();
        $result = true;
        try {
            $this->dbService->removeById($this->tableName, $user->getID());
            $this->dbService->removeById($this->emailsTableName, $user_id, 'user_id');
            $this->dbService->removeById($this->phonesTableName, $user_id, 'user_id');
            $this->dbService->removeById($this->addressesTableName, $user_id, 'user_id');
        } catch (mysqli_sql_exception $exception) {
            $this->dbService->rollback();
            $result = false;
        }
        return $result;
    }
}
