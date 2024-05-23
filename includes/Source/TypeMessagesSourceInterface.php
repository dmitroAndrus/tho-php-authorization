<?php

/**
 * This file contains TypeMessagesSourceInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Source;

use ThoPHPAuthorization\Source\MessagesSourceInterface;

/**
 * TypeMessagesSourceInterface is an interface, it declares a possibility to work with messages with specified types.
 */
interface TypeMessagesSourceInterface extends MessagesSourceInterface
{
    /**
     * Add message of specified type.
     *
     * @param mixed $message - Message.
     * @param mixed $type - Message type.
     *
     * @return self.
     */
    public function addOfType($message, $type = null);

    /**
     * Get all message of specified type.
     *
     * @param mixed $type - Message type.
     *
     * @return self.
     */
    public function getByType($type);

    /**
     * Get last message of specified type.
     *
     * @param mixed $type - Message type.
     *
     * @return self.
     */
    public function getLastByType($type);

    /**
     * Has messages of specified type.
     *
     * @param mixed $type - Message type.
     *
     * @return self.
     */
    public function hasOfType($type);

    /**
     * Get the number of messages of specified type.
     *
     * @param mixed $type - Message type.
     *
     * @return self.
     */
    public function countOfType($type);
}
