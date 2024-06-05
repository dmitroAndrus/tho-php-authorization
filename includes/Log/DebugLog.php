<?php

/**
 * This file contains DebugLog class.
 * PHP version 7.4
 *
 * @category Log
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Log;

use ThoPHPAuthorization\Log\DebugLogInterface;
use ThoPHPAuthorization\Log\ErrorLog;

/**
 * DebugLog is an class, that contains basic methods to work with debug logs.
 */
class DebugLog extends ErrorLog implements DebugLogInterface
{
    /**
     * Notice message type.
     *
     * @var integer.
     */
    public const TYPE_NOTICE = 3;

    /**
     * Debug message type.
     *
     * @var integer.
     */
    public const TYPE_DEBUG = 4;

    /**
     * {@inheritdoc}
     */
    public function notice($message)
    {
        return $this->source->addOfType($message, static::TYPE_NOTICE);
    }

    /**
     * {@inheritdoc}
     */
    public function getNotices()
    {
        return $this->source->getByType(static::TYPE_NOTICE);
    }

    /**
     * {@inheritdoc}
     */
    public function getLastNotice()
    {
        return $this->source->getLastByType(static::TYPE_NOTICE);
    }

    /**
     * {@inheritdoc}
     */
    public function hasNotices()
    {
        return $this->source->hasOfType(static::TYPE_NOTICE);
    }

    /**
     * {@inheritdoc}
     */
    public function countNotices()
    {
        return $this->source->countOfType(static::TYPE_NOTICE);
    }

    /**
     * {@inheritdoc}
     */
    public function debug($message)
    {
        return $this->source->addOfType($message, static::TYPE_DEBUG);
    }

    /**
     * {@inheritdoc}
     */
    public function getDebugMessages()
    {
        return $this->source->getByType(static::TYPE_DEBUG);
    }

    /**
     * {@inheritdoc}
     */
    public function getLastDebugMessage()
    {
        return $this->source->getLastByType(static::TYPE_DEBUG);
    }

    /**
     * {@inheritdoc}
     */
    public function hasDebugMessages()
    {
        return $this->source->hasOfType(static::TYPE_DEBUG);
    }

    /**
     * {@inheritdoc}
     */
    public function countDebugMessages()
    {
        return $this->source->countOfType(static::TYPE_DEBUG);
    }
}
