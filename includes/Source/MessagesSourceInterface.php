<?php

/**
 * This file contains MessagesSourceInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Source;

/**
 * MessagesSourceInterface is an interface, it declares a possibility to work with messages.
 */
interface MessagesSourceInterface
{
    /**
     * Cleanup messages.
     *
     * @return self.
     */
    public function cleanup();

    /**
     * Add message.
     *
     * @param mixed $message - Message.
     *
     * @return self.
     */
    public function add($message);

    /**
     * Get all messages.
     *
     * @return mixed|null - Messages or null, if there is no.
     */
    public function getAll();

    /**
     * Get last message.
     *
     * @return mixed|null - Last message or null, if there is no.
     */
    public function getLast();

    /**
     * Check if there are some messages.
     *
     * @return boolean.
     */
    public function isEmpty();

    /**
     * Count messages.
     *
     * @return integer.
     */
    public function count();
}
