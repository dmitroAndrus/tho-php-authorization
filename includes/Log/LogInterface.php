<?php

/**
 * This file contains LogInterface interface.
 * PHP version 7.4
 *
 * @category Log
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Log;

/**
 * LogInterface is an interface, that contains basic methods to work with logs.
 */
interface LogInterface
{
    /**
     * Cleanup log.
     *
     * @return self.
     */
    public function cleanup();

    /**
     * Add log message.
     *
     * @param mixed $message - Log message.
     *
     * @return self.
     */
    public function add($message);

    /**
     * Get all log messages.
     *
     * @return mixed|null - Messages or null, if there is no.
     */
    public function getAll();

    /**
     * Get last log message.
     *
     * @return mixed|null - Last message or null, if there is no.
     */
    public function getLast();

    /**
     * Check if there are some log messages.
     *
     * @return boolean.
     */
    public function isEmpty();

    /**
     * Count log messages.
     *
     * @return integer.
     */
    public function count();
}
