<?php

/**
 * This file contains AbstractUserRequestDBSource class.
 * php version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Source;

use ThoPHPAuthorization\Source\UserRequestSourceInterface;
use ThoPHPAuthorization\Source\UserSourceInterface;
use ThoPHPAuthorization\Service\DBServiceInterface;
use ThoPHPAuthorization\Data\User\UserRequestInterface;

/**
 * AbstractUserRequestDBSource is an abstract class,
 * that contains basic methods to get/store/edit user requests in Database.
 */
abstract class AbstractUserRequestDBSource implements UserRequestSourceInterface
{
    /**
     * Name to use in UUID v5.
     *
     * When generating UUID v5, user request type could be added as part of name.
     *
     * @var string
     */
    protected $name = 'user_access';

    /**
     * User request table name.
     *
     * @var string
     */
    protected $tableName = 'user_request';

    /**
     * Database service.
     *
     * @var DBServiceInterface
     */
    protected $dbService;

    /**
     * User source service.
     *
     * @var UserSourceInterface
     */
    protected $userSource;

    /**
     * Constructor.
     *
     * @param DBServiceInterface $db_service Database service.
     * @param UserSourceInterface $user_source User source.
     *
     * @return void
     */
    public function __construct(DBServiceInterface $db_service, UserSourceInterface $user_source)
    {
        $this->dbService = $db_service;
        $this->userSource = $user_source;
    }

    /**
     * Get data to store user request.
     *
     * @param UserRequestInterface $request User request object.
     *
     * @return array|null Data to store user request in database.
     */
    abstract public function getStoreData(UserRequestInterface &$request);

    /**
     * Get data to edit user request.
     *
     * @param UserRequestInterface $user User object.
     *
     * @return array|null Data to edit user in database.
     */
    public function getEditData(UserRequestInterface &$request)
    {
        return $this->getStoreData($request);
    }

    /**
     * Edit user request data.
     *
     * @param UserRequestInterface $request User request object.
     * @param array|null $data User request data.
     *
     * @return boolean Editing successful or not.
     */
    abstract public function editData(UserRequestInterface &$request, $data = null);

    /**
     * Get user request data from DB by request ID.
     *
     * @param integer|string $id User request ID.
     *
     * @return array|null User request data.
     */
    abstract protected function getDataByID($id);

    /**
     * Renew user request data.
     *
     * @param UserRequestInterface $request User request object.
     * @param string|integer $id User request id.
     *
     * @return boolean Successful or not.
     */
    public function renew(UserRequestInterface &$request, $id = null)
    {
        $request_id = $request->getID();
        if (!($id || $request_id) || ($request_id && $id != $request_id)) {
            return false;
        }
        if (is_null($request_id)) {
            $request_id = $id;
        }
        if ($id) {
            if (!$request_id) {
                $request->setID($id);
                $request_id = $id;
            } elseif ($request_id != $id) {
                // User request ID and provided ID missmatch.
                return false;
            }
        }
        if (!$request_id) {
            // No User ID provided.
            return false;
        }
        $data = $this->getDataByID($request_id);
        if (empty($data)) {
            // User request with provided ID not found.
            return false;
        }
        return $this->editData($request, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function store(UserRequestInterface &$request)
    {
        if ($this->exists($request)) {
            return false;
        }
        $store_data = $this->getStoreData($request);
        if ($this->validateData($store_data) && $this->dbService->insert($this->tableName, $store_data)) {
            return $this->renew($request, $this->dbService->getLastID());
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function edit(UserRequestInterface &$request, $data = null)
    {
        if (!$this->editData($request, $data)) {
            return false;
        }
        $store_data = $this->getEditData($request);
        if (
            $this->validateData($store_data)
            && $this->dbService->update($this->tableName, $request->getID(), $store_data)
        ) {
            return $this->renew($request);
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($request)
    {
        return $this->dbService->removeById(
            $this->tableName,
            $request instanceof UserRequestInterface
                ? $request->getID()
                : $request
        );
    }
}
