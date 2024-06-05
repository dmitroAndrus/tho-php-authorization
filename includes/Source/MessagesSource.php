<?php

/**
 * This file contains MessagesSource class.
 * PHP version 7.4
 *
 * @category Message
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Source;

use ThoPHPAuthorization\Source\MessagesSourceInterface;

/**
 * MessagesSource is a class, it declares a possibility to work with messages.
 *
 * Stores messages in object itself.
 */
class MessagesSource implements MessagesSourceInterface
{
    /**
     * Messages list.
     *
     * @var array.
     */
    protected $messages = [];

    /**
     * {@inheritdoc}
     */
    public function cleanup()
    {
        $this->messages = [];
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function add($message)
    {
        $this->messages[] = $message;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        return $this->isEmpty()
            ? null
            : $this->messages;
    }

    /**
     * {@inheritdoc}
     */
    public function getLast()
    {
        return $this->isEmpty()
            ? null
            : end($this->messages);
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return empty($this->messages);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->messages);
    }
}
