<?php

/**
 * This file contains AbstractUserDBSource interface.
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
use ThoPHPAuthorization\Service\DBServiceInterface;
use ThoPHPAuthorization\Data\User\UserRequestInterface;

/**
 * AbstractUserDBSource is an abstract class, that contains basic methods to get/store/edit user in Database.
 */
abstract class AbstractUserDBSource implements UserSourceInterface
{
    /**
     * User table name.
     *
     * @var string
     */
    protected $tableName = 'user';

    /**
     * Last inserted user id.
     *
     * @var mixed
     */
    protected $insertedUserID;

    /**
     * Database service.
     *
     * @var DBServiceInterface
     */
    protected $dbService;

    /**
     * Constructor.
     *
     * @param DBServiceInterface $db_service Database service.
     *
     * @return void
     */
    public function __construct(DBServiceInterface $db_service)
    {
        $this->dbService = $db_service;
    }

    /**
     * Get data to store user.
     *
     * @param UserInterface $user User object.
     *
     * @return array|null Data to store user in database.
     */
    abstract public function getStoreData(UserInterface &$user);

    /**
     * Get data to edit user.
     *
     * @param UserInterface $user User object.
     *
     * @return array|null Data to edit user in database.
     */
    public function getEditData(UserInterface &$user)
    {
        return $this->getStoreData($user);
    }

    /**
     * Edit user data.
     *
     * @param UserInterface $user User object.
     * @param array|null $data User data.
     *
     * @return boolean Editing successful or not.
     */
    abstract public function editData(UserInterface &$user, $data = null);

    /**
     * Get user data from DB by User ID.
     *
     * @param integer|string $id User ID.
     *
     * @return array|null User data.
     */
    abstract protected function getDataByID($id);

    /**
     * Renew user data.
     *
     * @param UserInterface $user User object.
     * @param string|integer $id User id.
     *
     * @return boolean Successful or not.
     */
    public function renew(UserInterface &$user, $id = null)
    {
        $user_id = $user->getID();
        if (
            !($id || $user_id)
            || (!is_null($id) && $user_id && $id != $user_id)
        ) {
            return false;
        }
        if (is_null($user_id)) {
            $user_id = $id;
        }
        if ($id) {
            if (!$user_id) {
                $user->setID($id);
                $user_id = $id;
            } elseif ($user_id != $id) {
                // User ID and provided ID missmatch.
                return false;
            }
        }
        if (!$user_id) {
            // No User ID provided.
            return false;
        }
        $data = $this->getDataByID($user_id);
        if (empty($data)) {
            // User with provided ID not found.
            return false;
        }
        return $this->editData($user, $data);
    }

    /**
     * Insert user data to database.
     *
     * @param array $data User data.
     *
     * @return boolean Successful or not.
     */
    protected function insert($data)
    {
        $result = $this->dbService->insert($this->tableName, $data);
        $this->insertedUserID = $this->dbService->getLastID();
        return $result;
    }

    /**
     * Insert user data to database.
     *
     * @param mixed $id User id.
     * @param array $data User data.
     *
     * @return boolean Successful or not.
     */
    protected function update($id, $data)
    {
        return $this->dbService->update($this->tableName, $id, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function store(UserInterface &$user, $renew = true)
    {
        $store_data = $this->getStoreData($user);
        $result = $this->validateData($store_data) && $this->insert($store_data);
        if ($result && $renew) {
            return $this->renew($user, $this->insertedUserID);
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function edit(UserInterface &$user, $data = null, $renew = true)
    {
        if (!$this->editData($user, $data)) {
            return false;
        }
        $store_data = $this->getEditData($user);
        $result = $this->validateData($store_data) && $this->update($user->getID(), $store_data);
        if ($result && $renew) {
            return $this->renew($user);
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($user)
    {
        return $this->dbService->removeById(
            $this->tableName,
            $user instanceof UserInterface
                ? $user->getID()
                : $user
        );
    }
}
