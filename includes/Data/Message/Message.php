<?php

/**
 * This file contains Message class.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Message;

use ThoPHPAuthorization\Data\Message\MessageInterface;
use ThoPHPAuthorization\Data\Message\MessageTrait;
use ThoPHPAuthorization\Data\Type\TypeTrait;

/**
 * Message is a class to manipulate message data.
 */
class Message implements MessageInterface
{
    use MessageTrait;
    use TypeTrait;

    /**
     * Constructor
     *
     * @param mixed $message Message text.
     * @param mixed $type Message type.
     *
     * @return void
     */
    public function __construct($message, $type = null)
    {
        $this->setMessage($message);
        $this->setType($type);
    }

    /**
     * Get string representation of object
     *
     * @return string
     */
    public function __toString()
    {
        $message = $this->getMessage();
        return $message ? (string) $message : '';
    }
}
