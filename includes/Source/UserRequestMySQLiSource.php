<?php

/**
 * This file contains UserRequestMySQLiSource interface.
 * php version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Source;

use ThoPHPAuthorization\Service\UUID;
use ThoPHPAuthorization\User\UserInterface;
use ThoPHPAuthorization\User\BasicUser;
use ThoPHPAuthorization\Source\DBSourceTrait;
use ThoPHPAuthorization\Source\UserKeepInterface;

/**
 * UserRequestMySQLiSource is a class, that contains basic methods to get/store/edit user requests in MySQL Database.
 */
class UserRequestMySQLiSource extends AbstractUserRequestDBSource
{
    /**
     * Name to use in UUID v5.
     *
     * When generating UUID v5, user request type could be added as part of name.
     *
     * @var string
     */
    protected $name = 'user_request_source';

    /**
     * Constructor.
     *
     * @param DBServiceInterface $db_service Database service.
     * @param UserSourceInterface $user_source User source.
     *
     * @return void
     */
    public function __construct(DBServiceInterface $db_service, UserSourceInterface $user_source, $name = null)
    {
        parent::__construct($db_service, $user_source);
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDataByID($id)
    {
        $result = $this->dbService->queryFirst("
            SELECT *
            FROM {$this->dbService->getTableName($this->tableName)}
            WHERE
                id = '{$this->dbService->escape($id)}'
            LIMIT 1
        ");
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getByID($id)
    {
        $result = $this->getDataByID($id);
        return $result ? $this->create($result) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getBySecurity($security)
    {
        $result = $this->dbService->queryFirst("
            SELECT *
            FROM {$this->dbService->getTableName($this->tableName)}
            WHERE
                security = '{$this->dbService->escape($security)}'
            LIMIT 1
        ");
        if (!$result) {
            return null;
        }
        $user = $this->userSource->getById($result['user_id']);
        return $this->create($user, $result);
    }

    /**
     * {@inheritdoc}
     */
    public function create(UserInterface $user, $data = null)
    {
        $create_data = is_array($data) ? $data : [];
        $create_data['user'] = $user;
        $type = isset($data['type']) ? $data['type'] : null;
        switch ($type) {
            case UserForgotPasswordRequest::TYPE:
                return $this->createForgotPasswordRequest($create_data);
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function exists(UserRequestInterface &$request)
    {
        $result = $this->dbService->getById($this->tableName, $request->getID());
        return !!$result;
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreData(UserRequestInterface &$request)
    {
        $id = $this->dbService->getUUID($this->keepTableName);
        $data = [
            'id' => $id,
            'security' => UUID::v5($id, $this->name . $request::TYPE),
            'created' => $user->getCreated('Y-m-d h:i:s'),
            'valid_until' => $user->getValidUntil('Y-m-d h:i:s'),
            'type' => $request::TYPE
        ];
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getEditData(UserRequestInterface &$request)
    {
        return [
            'id' => $request->getID(),
            'security' => $request->getSecurity(),
            'created' => $request->getCreated('Y-m-d h:i:s'),
            'valid_until' => $request->getValidUntil('Y-m-d h:i:s'),
            'type' => $request::TYPE
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function editData(UserRequestInterface &$request, $data = null)
    {
        $date_time_format = isset($data['date_time_format'])
            ? $data['date_time_format']
            : (isset($data['dateTimeFormat'])
                ? $data['dateTimeFormat']
                : null);
        // ID.
        if (isset($data['id'])) {
            $request->setID($data['id']);
        }
        // Security key.
        if (isset($data['security'])) {
            $request->setSecurity($data['security']);
        }
        // Valid until.
        if (isset($data['valid_until']) && !empty($data['valid_until'])) {
            $request->setValidUntil(
                $data['valid_until'],
                isset($data['valid_until_format'])
                    ? $data['valid_until_format']
                    : (isset($data['validUntilFormat'])
                        ? $data['validUntilFormat']
                        : $date_time_format)
            );
        }
        return true;
    }
}
