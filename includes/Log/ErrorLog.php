<?php

/**
 * This file contains ErrorLog class.
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
use ThoPHPAuthorization\Log\Log;
use ThoPHPAuthorization\Source\TypeMessagesSourceInterface;
use ThoPHPAuthorization\Source\TypeMessagesSource;

/**
 * ErrorLog is an class, that contains basic methods to work with error logs.
 *
 * It uses TypeMessagesSourceInterface object to manage messages.
 * It's done to provide ability to store log messages in source object, file, database, etc.
 */
class ErrorLog extends Log implements ErrorLogInterface
{
    /**
     * Error message type.
     *
     * @var integer
     */
    public const TYPE_ERROR = 1;

    /**
     * Warning message type.
     *
     * @var integer
     */
    public const TYPE_WARNING = 2;

    /**
     * Constructor.
     *
     * TypeMessagesSourceInterface object can be provided or it will create a TypeMessagesSource object,
     * and will store log messages in it.
     *
     * @param TypeMessagesSourceInterface $source Messages source.
     *
     * @return void
     */
    public function __construct(TypeMessagesSourceInterface $source = null)
    {
        $this->source = is_null($source)
            ? new TypeMessagesSource(static::TYPE_ERROR)
            : $source;
    }

    /**
     * {@inheritdoc}
     */
    public function error($message)
    {
        return $this->source->addOfType($message, static::TYPE_ERROR);
    }

    /**
     * {@inheritdoc}
     */
    public function getErrors()
    {
        return $this->source->getByType(static::TYPE_ERROR);
    }

    /**
     * {@inheritdoc}
     */
    public function getLastError()
    {
        return $this->source->getLastByType(static::TYPE_ERROR);
    }

    /**
     * {@inheritdoc}
     */
    public function hasErrors()
    {
        return $this->source->hasOfType(static::TYPE_ERROR);
    }

    /**
     * {@inheritdoc}
     */
    public function countErrors()
    {
        return $this->source->countOfType(static::TYPE_ERROR);
    }

    /**
     * {@inheritdoc}
     */
    public function warning($message)
    {
        return $this->source->addOfType($message, static::TYPE_WARNING);
    }

    /**
     * {@inheritdoc}
     */
    public function getWarnings()
    {
        return $this->source->getByType(static::TYPE_WARNING);
    }

    /**
     * {@inheritdoc}
     */
    public function getLastWarning()
    {
        return $this->source->getLastByType(static::TYPE_WARNING);
    }

    /**
     * {@inheritdoc}
     */
    public function hasWarnings()
    {
        return $this->source->hasOfType(static::TYPE_WARNING);
    }

    /**
     * {@inheritdoc}
     */
    public function countWarnings()
    {
        return $this->source->countOfType(static::TYPE_WARNING);
    }
}
