<?php

/**
 * This file contains HasMessageInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Message;

/**
 * HasMessageInterface is an interface, it declares a possibility to access to the message data.
 */
interface HasMessageInterface
{
    /**
     * Set message.
     *
     * @param string $text Message text.
     *
     * @return self
     */
    public function setMessage($text);

    /**
     * Get message.
     *
     * @return string
     */
    public function getMessage();
}
