<?php

/**
 * This file contains ReadableLogTrait trait.
 * PHP version 7.4
 *
 * @category Log
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Log;

use ThoPHPAuthorization\Log\LogInterface;

/**
 * ReadableLogTrait is a trait, that contains basic methods to get data from the log object.
 *
 * Used to provide read only access to log.
 *
 * Log object should be set manualy, for example, in the constructor.
 */
trait ReadableLogTrait
{
    /**
     * Log.
     *
     * @var LogInterface
     */
    protected $log;

    /**
     * Get all log messages.
     *
     * @return mixed|null Messages or null, if there is no.
     */
    public function getAllLogMessages()
    {
        return $this->log->getAll();
    }

    /**
     * Get last log message.
     *
     * @return mixed|null Last message or null, if there is no.
     */
    public function getLastLogMessage()
    {
        return $this->log->getLast();
    }

    /**
     * Check if there are some log messages.
     *
     * @return boolean
     */
    public function hasEmptyLog()
    {
        return $this->log->isEmpty();
    }

    /**
     * Count log messages.
     *
     * @return integer
     */
    public function countLogMessages()
    {
        return $this->log->count();
    }
}
