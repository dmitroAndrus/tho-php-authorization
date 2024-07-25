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
use ThoPHPAuthorization\Data\User\UserRequestInterface;
use ThoPHPAuthorization\Data\User\UserForgotPasswordRequest;

/**
 * UserRequestMySQLiSource is a class, that contains basic methods to get/store/edit user requests in MySQL Database.
 */
class UserRequestMySQLiSource extends AbstractUserRequestDBSource
{
    /**
     * Decode encoded data
     *
     * @param string $string Encoded data.
     *
     * @return string|null Decoded data or null.
     */
    public function decode($string)
    {
        $result = base64_decode($string, true);
        return $result ?: null;
    }

    /**
     * Encode data
     *
     * @param string $string Encoded data.
     *
     * @return string
     */
    public function encode($string)
    {
        return base64_encode($string);
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
                security = '{$this->dbService->escape($this->decode($security))}'
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
    public function validateData($data)
    {
        return isset($data['id']) && !empty($data['id'])
            && isset($data['security']) && !empty($data['security']);
    }

    /**
     * {@inheritdoc}
     */
    public function create(UserInterface $user, $data = null)
    {
        $create_data = is_array($data) ? $data : [];
        $create_data['user'] = $user;
        $type = isset($data['type']) ? $data['type'] : null;
        switch ((string) $type) {
            case UserForgotPasswordRequest::TYPE:
            case '1':
                return new UserForgotPasswordRequest($create_data);
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function exists(UserRequestInterface &$request)
    {
        if (!$request->getID()) {
            return false;
        }
        $result = $this->dbService->getById($this->tableName, $request->getID());
        return !!$result;
    }

    /**
     * Get type value to store.
     *
     * @param DBServiceInterface $db_service Database service.
     *
     * @return void
     */
    protected function getStoreDataType(UserRequestInterface $request)
    {
        switch ($request::TYPE) {
            case UserForgotPasswordRequest::TYPE:
                return 1;
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreData(UserRequestInterface &$request)
    {
        $id = $this->dbService->getUUID($this->tableName);
        $user = $request->getUser();
        $data = [
            'id' => $id,
            'user_id' => $user ? $user->getID() : null,
            'security' => UUID::v5($id, $this->name . $request::TYPE),
            'created' => $request->getCreated('Y-m-d h:i:s'),
            'valid_until' => $request->getValidUntil('Y-m-d h:i:s'),
            'type' => $this->getStoreDataType($request)
        ];
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getEditData(UserRequestInterface &$request)
    {
        $user = $request->getUser();
        return [
            'id' => $request->getID(),
            'user_id' => $user ? $user->getID() : null,
            'security' => $this->decode($request->getSecurity()),
            'created' => $request->getCreated('Y-m-d h:i:s'),
            'valid_until' => $request->getValidUntil('Y-m-d h:i:s'),
            'type' => $this->getStoreDataType($request)
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
            $request->setSecurity($this->encode($data['security']));
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

    /**
     * {@inheritdoc}
     */
    public function resolve(UserRequestInterface $request, $data = null)
    {
        $user = $request->getUser();
        switch ($request::TYPE) {
            case UserForgotPasswordRequest::TYPE:
                return isset($data['password'])
                    ? $this->userSource->edit(
                        $user,
                        [
                            'password' => $data['password']
                        ]
                    )
                    : false;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function removeExpired()
    {
        $query = "
            DELETE
            FROM `{$this->dbService->getTableName($this->tableName)}`
            WHERE valid_until IS NOT NULL AND valid_until <= NOW()
        ";
        return $this->dbService->query($query) === true;
    }

    /**
     * {@inheritdoc}
     */
    protected function cleanupBeforeStore($data)
    {
        if (!in_array($data['type'], array('1'))) {
            return true;
        }
        $query = "
            DELETE
            FROM `{$this->dbService->getTableName($this->tableName)}`
            WHERE user_id = '{$this->dbService->escape($data['user_id'])}'
                AND type = '{$this->dbService->escape($data['type'])}'
        ";
        return $this->dbService->query($query) === true;
    }
}
