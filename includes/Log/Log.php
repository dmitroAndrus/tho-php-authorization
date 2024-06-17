<?php

/**
 * This file contains Log class.
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
use ThoPHPAuthorization\Source\MessagesSourceInterface;
use ThoPHPAuthorization\Source\MessagesSource;

/**
 * Log is a class, that contains basic methods to work with logs.
 *
 * It uses MessagesSourceInterface object to manage messages.
 * It's done to provide ability to store log messages in source object, file, database, etc.
 */
class Log implements LogInterface
{
    /**
     * Default log.
     *
     * @var LogInterface
     */
    public static $defaultLog = null;

    /**
     * Messages source.
     *
     * @var MessagesSourceInterface
     */
    protected $source;

    /**
     * Constructor.
     *
     * MessagesSourceInterface object can be provided or it will create a MessagesSource object,
     * and will store log messages in it.
     *
     * @param MessagesSourceInterface $source Messages source.
     *
     * @return void
     */
    public function __construct(MessagesSourceInterface $source = null)
    {
        $this->source = is_null($source)
            ? new MessagesSource()
            : $source;
    }

    /**
     * {@inheritdoc}
     */
    public function cleanup()
    {
        $this->source->cleanup();
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function add($message)
    {
        $this->source->add($message);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        return $this->source->getAll();
    }

    /**
     * {@inheritdoc}
     */
    public function getLast()
    {
        return $this->source->getLast();
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return $this->source->isEmpty();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->source->count();
    }
}
