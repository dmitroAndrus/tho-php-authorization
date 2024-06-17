<?php

/**
 * This file contains MessageTrait trait.
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
 * MessageTrait is a trait, it contains basic methods to manipulate message data.
 *
 * Implements everything from {@see \ThoPHPAuthorization\Data\Message\HasMessageInterface}.
 */
trait MessageTrait
{
    /**
     * Message.
     *
     * @var string
     */
    protected $message;

    /**
     * Set message.
     *
     * @param string $text Message text.
     *
     * @return self
     */
    public function setMessage($text)
    {
        $this->message = $text;
        return $this;
    }

    /**
     * Get message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
