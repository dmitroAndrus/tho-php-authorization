<?php

/**
 * This file contains ReadableDebugLogTrait trait.
 * PHP version 7.4
 *
 * @category Log
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Log;

use ThoPHPAuthorization\Log\ReadableLogTrait;

/**
 * ReadableDebugLogTrait is a trait, that contains basic methods to get data from the debug log object.
 *
 * Used to provide read only access to log.
 * Log object should be set manualy, for example, in the constructor.
 */
trait ReadableDebugLogTrait
{
    use ReadableErrorLogTrait;

    /**
     * Get notice messages.
     *
     * @return mixed
     */
    public function getNotices()
    {
        return $this->log->getNotices();
    }

    /**
     * Get last notice message.
     *
     * @return mixed
     */
    public function getLastNotice()
    {
        return $this->log->getLastNotice();
    }

    /**
     * Check if there were notice messages.
     *
     * @return boolean
     */
    public function hasNotices()
    {
        return $this->log->hasNotices();
    }

    /**
     * Count notice messages.
     *
     * @return integer
     */
    public function countNotices()
    {
        return $this->log->countNotices();
    }

    /**
     * Get debug messages.
     *
     * @return mixed
     */
    public function getDebugMessages()
    {
        return $this->log->getDebugMessages();
    }

    /**
     * Get last debug message.
     *
     * @return mixed
     */
    public function getLastDebugMessage()
    {
        return $this->log->getLastDebugMessage();
    }

    /**
     * Check if there were debug messages.
     *
     * @return boolean
     */
    public function hasDebugMessages()
    {
        return $this->log->hasDebugMessages();
    }

    /**
     * Count debug messages.
     *
     * @return integer
     */
    public function countDebugMessages()
    {
        return $this->log->countDebugMessages();
    }
}
