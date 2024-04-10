<?php

/**
 * This file contains DBServiceInterface interface.
 * php version 7.4
 *
 * @category Service
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Service;

use ThoPHPAuthorization\User\UserInterface;

/**
 * DBServiceInterface is an interface, it declares a possibility to access and manipulate a Database.
 */
interface DBServiceInterface
{
    /**
     * Get table name.
     *
     * @param string $table_name - Database table name.
     *
     * @return string - table name.
     */
    public function getTableName(string $table_name);

    /**
     * Insert new data to database.
     *
     * @param string $table_name - Database table to insert data at.
     * @param mixed $data - Data to insert.
     *
     * @return boolean - storing successful or not.
     */
    public function insert(string $table_name, $data);

    /**
     * Edit/update existing data in database.
     *
     * @param string $table_name - Database table to update data at.
     * @param mixed $id - ID of the record to update.
     * @param mixed $data - Data to update.
     * @param string $id_column - ID column name.
     *
     * @return boolean - edit/update is successful or not.
     */
    public function update(string $table_name, $id, $data, $id_column = null);

    /**
     * Get the value generated for an AUTO_INCREMENT column by the last query.
     *
     * @return mixed.
     */
    public function getLastID();

    /**
     * Escape value for database.
     *
     * @param mixed $value - Value to escape.
     *
     * @return string.
     */
    public function escape($value);

    /**
     * Performs a query on the database.
     *
     * @param mixed $query - Query.
     *
     * @return mixed - query result.
     */
    public function query($query);

    /**
     * Performs a query on the database, and returns first match.
     *
     * @param mixed $query - Query.
     *
     * @return mixed.
     */
    public function queryFirst($query);

    /**
     * Performs a query on the database, and returns all matched record.
     *
     * @param mixed $query - Query.
     *
     * @return mixed.
     */
    public function queryAll($query);
}
