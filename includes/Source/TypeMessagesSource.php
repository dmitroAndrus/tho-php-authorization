<?php

/**
 * This file contains TypeMessagesSource class.
 * PHP version 7.4
 *
 * @category Message
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Source;

use ThoPHPAuthorization\Data\Message\MessageInterface;
use ThoPHPAuthorization\Data\Message\Message;
use ThoPHPAuthorization\Source\TypeMessagesSourceInterface;
use ThoPHPAuthorization\Source\MessagesSource;
use ThoPHPAuthorization\Data\Type\DefaultTypeTrait;

/**
 * TypeMessagesSource is a class, it declares a possibility to work with messages.
 *
 * Stores messages in object itself.
 */
class TypeMessagesSource extends MessagesSource implements TypeMessagesSourceInterface
{
    use DefaultTypeTrait;

    /**
     * Constructor
     *
     * @param mixed $default_type Default message type.
     *
     * @return void
     */
    public function __construct($default_type = 'default')
    {
        $this->setDefaultType($default_type);
    }

    /**
     * {@inheritdoc}
     */
    public function add($message)
    {
        if ($message instanceof MessageInterface) {
            $this->messages[] = $message;
        } else {
            $this->messages[] = new Message($message, $this->getDefaultType());
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addOfType($message, $type = null)
    {
        if (($message instanceof MessageInterface) || is_null($type)) {
            return $this->add($message);
        }
        return $this->add(new Message($message, $type));
    }

    /**
     * {@inheritdoc}
     */
    public function getByType($type)
    {
        $messages = $this->getAll();
        if (is_null($messages)) {
            return null;
        }
        $result = [];
        foreach ($messages as $message) {
            if ($message->isOfType($type)) {
                $result[] = $message;
            }
        }
        return empty($result)
            ? null
            : $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastByType($type)
    {
        $messages = $this->getAll();
        if (is_null($messages)) {
            return null;
        }
        $result = [];
        for ($i = count($messages) - 1; $i > -1; $i--) {
            $message = $messages[$i];
            if ($message->isOfType($type)) {
                return $message;
            }
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function hasOfType($type)
    {
        return !is_null($this->getLastByType($type));
    }

    /**
     * {@inheritdoc}
     */
    public function countOfType($type)
    {
        $messages = $this->getAll();
        if (is_null($messages)) {
            return 0;
        }
        $count = 0;
        foreach ($messages as $message) {
            if ($message->isOfType($type)) {
                $count++;
            }
        }
        return $count;
    }
}
