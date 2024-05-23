<?php

/**
 * This file contains BasicUserMySQLiSource interface.
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
 * BasicUserMySQLiSource is a class, that contains basic methods to get/store/edit user in MySQL Database.
 */
class BasicUserMySQLiSource extends AbstractUserDBSource implements UserKeepInterface
{
    /**
     * User table name.
     *
     * @var string
     */
    protected $keepTableName = 'user_keep';

    /**
     * Get user data from DB by User ID.
     *
     * @param integer|string $id - User ID.
     *
     * @return array|null - User data.
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
     * Get user data from DB by User name.
     *
     * @param string $ame - User name.
     *
     * @return array|null - User data.
     */
    protected function getDataByName($name)
    {
        $result = $this->dbService->queryFirst("
            SELECT *
            FROM {$this->dbService->getTableName($this->tableName)}
            WHERE
                name = '{$this->dbService->escape($name)}'
            LIMIT 1
        ");
        return $result;
    }

    /**
     * ${@inheritdoc}
     */
    public function getByID($id)
    {
        $result = $this->getDataByID($id);
        return $result ? $this->create($result) : null;
    }

    /**
     * ${@inheritdoc}
     */
    public function getByIdentity($identity)
    {
        $result = $this->getDataByName($identity);
        return $result ? $this->create($result) : null;
    }

    /**
     * ${@inheritdoc}
     */
    public function validateData($data)
    {
        return isset($data['name']) && !empty($data['name'])
            && (
                (isset($data['security']) && !empty($data['security']))
                || (isset($data['password']) && !empty($data['password']))
            );
    }

    /**
     * ${@inheritdoc}
     */
    public function create($data)
    {
        return $this->validateData($data)
            ? new BasicUser($data)
            : null;
    }

    /**
     * ${@inheritdoc}
     */
    public function userExists(UserInterface &$user)
    {
        $where = [
            'name' => "name = '{$this->dbService->escape($user->getName())}'"
        ];
        if ($user->getID()) {
            $where['id'] = "id = '{$this->dbService->escape($user->getID())}'";
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
        return [
            'name' => $user->getName(),
            'security' => $user->getPassword(),
        ];
    }

    /**
     * ${@inheritdoc}
     */
    public function editData(UserInterface &$user, $data = null)
    {
        // Set User Name.
        if (isset($data['name']) && !empty($data['name'])) {
            $user->setName($data['name']);
        }
        // Set User security key directly or password (convert to security key).
        if (isset($data['security']) && !empty($data['security'])) {
            $user->setSecurity($data['security']);
        } elseif (isset($data['password']) && !empty($data['password'])) {
            $user->setPassword($data['password']);
        }
        return true;
    }

    /**
     * Generate UUID.
     *
     * @param mixed $id - Keep record id.
     * @param string $name - Unique name.
     *
     * @return string - UUID.
     */
    protected function getUUID(&$id, $name)
    {
        do {
            $id = UUID::v4();
            $result = $this->dbService->queryFirst("
                SELECT *
                FROM {$this->dbService->getTableName($this->keepTableName)}
                WHERE
                    id = '{$this->dbService->escape($id)}'
                LIMIT 1
            ");
        } while ($result);
        return UUID::v5($id, $name);
    }

    /**
     * ${@inheritdoc}
     */
    public function keep(UserInterface $user, $valid_until, $name = null)
    {
        if (empty($name)) {
            $name = 'default';
        }
        $id = null;
        $security = $this->getUUID($id, $name);
        $data = [
            'id' => $id,
            'user_id' => $user->getID(),
            'security' => $security,
            'valid_until' => date('Y-m-d h:i:s', $valid_until),
        ];
        if (!$this->dbService->insert($this->keepTableName, $data)) {
            return false;
        }
        return $security;
    }

    /**
     * ${@inheritdoc}
     */
    public function restoreKeeped($security)
    {
        $result = $this->dbService->queryFirst("
            SELECT *
            FROM {$this->dbService->getTableName($this->keepTableName)}
            WHERE
                security = '{$this->dbService->escape($security)}'
            LIMIT 1
        ");
        return $result ? $this->getByID($result['user_id']) : null;
    }

    /**
     * ${@inheritdoc}
     */
    public function releaseKeeped($security)
    {
        $result = $this->dbService->query("
            DELETE FROM {$this->dbService->getTableName($this->keepTableName)}
            WHERE
                security = '{$this->dbService->escape($security)}'
        ");
        return $result !== false;
    }
}
