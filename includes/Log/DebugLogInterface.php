<?php

/**
 * This file contains DebugLogInterface interface.
 * PHP version 7.4
 *
 * @category Log
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Log;

use ThoPHPAuthorization\Log\ErrorLogInterface;

/**
 * DebugLogInterface is an interface, that contains basic methods to work with debug logs.
 */
interface DebugLogInterface extends ErrorLogInterface
{
    /**
     * Add notice log message.
     *
     * @param mixed $message - Notice log message.
     *
     * @return self.
     */
    public function notice($message);

    /**
     * Get notice messages.
     *
     * @return mixed.
     */
    public function getNotices();

    /**
     * Get last notice message.
     *
     * @return mixed.
     */
    public function getLastNotice();

    /**
     * Check if there were notice messages.
     *
     * @return boolean.
     */
    public function hasNotices();

    /**
     * Count notice messages.
     *
     * @return integer.
     */
    public function countNotices();

    /**
     * Add debug log message.
     *
     * @param mixed $message - Debug log message.
     *
     * @return self.
     */
    public function debug($message);

    /**
     * Get debug messages.
     *
     * @return mixed.
     */
    public function getDebugMessages();

    /**
     * Get last debug message.
     *
     * @return mixed.
     */
    public function getLastDebugMessage();

    /**
     * Check if there were debug messages.
     *
     * @return boolean.
     */
    public function hasDebugMessages();

    /**
     * Count debug messages.
     *
     * @return integer.
     */
    public function countDebugMessages();
}
