<?php

/**
 * This file contains MySQLiService class.
 * PHP version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Service;

use ThoPHPAuthorization\Service\UUID;

/**
 * MySQLiService is a class, that contains functionality to work with MySQL database.
 */
class MySQLiService implements DBServiceInterface
{
    /**
     * Database connection.
     *
     * @var mysqli
     */
    protected $connection;

    /**
     * Table prefix.
     *
     * @var string
     */
    protected $table_prefix;

    /**
     * Constructor.
     *
     * @param string $hostname Database host name or IP address.
     * @param string $database Database name.
     * @param string $username Database user name.
     * @param string $password Database user password.
     * @param integer $port Database port number.
     * @param string $socket Database socket.
     * @param string $charset Database charset.
     *
     * @return void
     */
    public function __construct(
        $hostname,
        $database,
        $username,
        $password = '',
        $port = null,
        $socket = null,
        $charset = null,
        $prefix = null
    ) {
        $connection = new \mysqli($hostname, $username, $password, $database, $port, $socket);
        if ($connection->connect_errno) {
            throw new \RuntimeException('Connection error mysqli: ' . $connection->connect_error);
        }
        if (!is_null($charset)) {
            $connection->set_charset($charset);
            if ($connection->errno) {
                throw new \RuntimeException('Error mysqli: ' . $connection->error);
            }
        }
        $this->connection = $connection;
        $this->table_prefix = empty($prefix) ? '' : $this->escape($prefix);
    }

    /**
     * {@inheritdoc}
     */
    public function getTableName($table_name)
    {
        return $this->escape("{$this->table_prefix}{$this->escape($table_name)}");
    }

    /**
     * {@inheritdoc}
     */
    public function startTransaction()
    {
        return $this->connection->begin_transaction();
    }

    /**
     * {@inheritdoc}
     */
    public function commit()
    {
        return $this->connection->commit();
    }

    /**
     * {@inheritdoc}
     */
    public function rollback()
    {
        return $this->connection->rollback();
    }

    /**
     * Create array of set values strings.
     *
     * @param array $data Array of $column_name => $value.
     *
     * @return array Array of set values.
     */
    public function createSetValues($data)
    {
        $values = [];
        foreach ($data as $key => $value) {
            $values[] = "{$this->escape($key)} = '{$this->escape($value)}'";
        }
        return $values;
    }

    /**
     * {@inheritdoc}
     */
    public function insert(string $table_name, $data)
    {
        $values = $this->createSetValues($data);
        $query = "
            INSERT INTO `{$this->getTableName($table_name)}`
            SET " . implode(', ', $values) . "
        ";
        return $this->connection->query($query) === true;
    }

    /**
     * {@inheritdoc}
     */
    public function update(string $table_name, $id, $data, $id_column = null)
    {
        $_id_column = empty($id_column) ? 'id' : $id_column;
        $values = $this->createSetValues($data);
        $query = "
            UPDATE `{$this->getTableName($table_name)}`
            SET " . implode(', ', $values) . "
            WHERE {$this->escape($_id_column)} = '{$this->escape($id)}'
        ";
        return $this->connection->query($query) === true;
    }

    /**
     * {@inheritdoc}
     */
    public function getById(string $table_name, $id, $id_column = null)
    {
        $_id_column = empty($id_column) ? 'id' : $id_column;
        $query = "
            SELECT *
            FROM `{$this->getTableName($table_name)}`
            WHERE {$this->escape($_id_column)} = '{$this->escape($id)}'
        ";
        $result = $this->connection->query($query);
        return $result && $result->num_rows
            ? $result->fetch_assoc()
            : null;
    }

    /**
     * {@inheritdoc}
     */
    public function removeById(string $table_name, $id, $id_column = null)
    {
        $_id_column = empty($id_column) ? 'id' : $id_column;
        $query = "
            DELETE *
            FROM `{$this->getTableName($table_name)}`
            WHERE {$this->escape($_id_column)} = '{$this->escape($id)}'
        ";
        return $this->connection->query($query) === true && $this->connection->affected_rows > 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getUUID(string $table_name, $id_column = null)
    {
        $id_column = $this->dbService->escape(empty($id_column) ? 'id' : $id_column);
        $table_name = $this->getTableName($table_name);
        do {
            $id = UUID::v4();
            $result = $this->dbService->queryFirst("
                SELECT *
                FROM {$table_name}
                WHERE
                    '{$id_column}' = '{$this->dbService->escape($id)}'
                LIMIT 1
            ");
        } while ($result);
        return $id;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastID()
    {
        return $this->connection->insert_id;
    }

    /**
     * {@inheritdoc}
     */
    public function escape($value)
    {
        return $this->connection->real_escape_string($value);
    }

    /**
     * {@inheritdoc}
     */
    public function query($query)
    {
        return $this->connection->query($query);
    }

    /**
     * {@inheritdoc}
     */
    public function queryFirst($query)
    {
        $result = $this->connection->query($query);
        return $result && $result->num_rows
            ? $result->fetch_assoc()
            : null;
    }

    /**
     * {@inheritdoc}
     */
    public function queryAll($query)
    {
        $result = $this->connection->query($query);
        return $result && $result->num_rows
            ? $result->fetch_all(MYSQLI_ASSOC)
            : null;
    }
}
