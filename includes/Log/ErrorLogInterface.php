<?php

/**
 * This file contains ErrorLogInterface interface.
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
 * ErrorLogInterface is an interface, that contains basic methods to work with error logs.
 */
interface ErrorLogInterface extends LogInterface
{
    /**
     * Add error log message.
     *
     * @param mixed $message Error log message.
     *
     * @return self
     */
    public function error($message);

    /**
     * Get error messages.
     *
     * @return mixed
     */
    public function getErrors();

    /**
     * Get last error message.
     *
     * @return mixed
     */
    public function getLastError();

    /**
     * Check if there were error messages.
     *
     * @return boolean
     */
    public function hasErrors();

    /**
     * Count error messages.
     *
     * @return integer
     */
    public function countErrors();

    /**
     * Add warning log message.
     *
     * @param mixed $message Warning log message.
     *
     * @return self
     */
    public function warning($message);

    /**
     * Get warning messages.
     *
     * @return mixed
     */
    public function getWarnings();

    /**
     * Get last warning message.
     *
     * @return mixed
     */
    public function getLastWarning();

    /**
     * Check if there were warning messages.
     *
     * @return boolean
     */
    public function hasWarnings();

    /**
     * Count warning messages.
     *
     * @return integer
     */
    public function countWarnings();
}
