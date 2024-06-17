<?php

/**
 * This file contains ReadableErrorLogTrait trait.
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
 * ReadableErrorLogTrait is a trait, that contains basic methods to get data from the error log object.
 *
 * Used to provide read only access to log.
 * Log object should be set manualy, for example, in the constructor.
 */
trait ReadableErrorLogTrait
{
    use ReadableLogTrait;

    /**
     * Get error messages.
     *
     * @return mixed
     */
    public function getErrors()
    {
        return $this->log->getErrors();
    }

    /**
     * Get last error message.
     *
     * @return mixed
     */
    public function getLastError()
    {
        return $this->log->getLastError();
    }

    /**
     * Check if there were error messages.
     *
     * @return boolean
     */
    public function hasErrors()
    {
        return $this->log->hasErrors();
    }

    /**
     * Count error messages.
     *
     * @return integer
     */
    public function countErrors()
    {
        return $this->log->countErrors();
    }

    /**
     * Get warning messages.
     *
     * @return mixed
     */
    public function getWarnings()
    {
        return $this->log->getWarnings();
    }

    /**
     * Get last warning message.
     *
     * @return mixed
     */
    public function getLastWarning()
    {
        return $this->log->getLastWarning();
    }

    /**
     * Check if there were warning messages.
     *
     * @return boolean
     */
    public function hasWarnings()
    {
        return $this->log->hasWarnings();
    }

    /**
     * Count warning messages.
     *
     * @return integer
     */
    public function countWarnings()
    {
        return $this->log->countWarnings();
    }
}
