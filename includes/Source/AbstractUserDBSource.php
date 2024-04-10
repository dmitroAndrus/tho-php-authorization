<?php

/**
 * This file contains AbstractUserDBSource interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Source;

use ThoPHPAuthorization\User\UserInterface;
use ThoPHPAuthorization\Service\DBServiceInterface;

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
     * Database service.
     *
     * @var DBServiceInterface
     */
    protected $dbService;

    /**
     * Constructor.
     *
     * @param DBServiceInterface $db_service - Database service.
     *
     * @return void.
     */
    public function __construct(DBServiceInterface $db_service)
    {
        $this->dbService = $db_service;
    }

    /**
     * Get data to store user.
     *
     * @param UserInterface $user - User object.
     *
     * @return array|null - data to store in database.
     */
    abstract public function getStoreData(UserInterface &$user);

    /**
     * Edit user data.
     *
     * @param UserInterface $user - User object.
     * @param array|null $data - User data.
     *
     * @return boolean - editing successful or not.
     */
    abstract public function editData(UserInterface &$user, $data = null);

    /**
     * Renew user data.
     *
     * @param UserInterface $user - User object.
     * @param string|integer $id - User id.
     *
     * @return boolean - successful or not.
     */
    abstract public function renew(UserInterface &$user, $id = null);

    /**
     * ${@inheritdoc}
     */
    public function store(UserInterface &$user)
    {
        if ($this->userExists($user)) {
            return false;
        }
        $store_data = $this->getStoreData($user);
        if ($store_data && $this->dbService->insert($this->tableName, $store_data)) {
            return $this->renew($user, $this->dbService->getLastID());
        }
        return false;
    }

    /**
     * ${@inheritdoc}
     */
    public function edit(UserInterface &$user, $data = null)
    {
        if (!$this->editData($user, $data)) {
            return false;
        }
        $store_data = $this->getStoreData($user);
        if ($store_data && $this->dbService->update($this->tableName, $user->getID(), $store_data)) {
            return $this->renew($user);
        }
        return false;
    }
}
