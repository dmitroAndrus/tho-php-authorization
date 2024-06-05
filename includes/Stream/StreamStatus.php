<?php

/**
 * This file contains StreamStatus class.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Stream;

/**
 * StreamStatus is a class, that contains steam statuses.
 */
class StreamStatus
{
    /**
     * Stream is closed.
     *
     * @var integer
     */
    public const CLOSED = 0;

    /**
     * Stream has errors.
     *
     * @var integer
     */
    public const ERROR = -1;

    /**
     * Failed to close the stream.
     *
     * @var integer
     */
    public const CLOSE_ERROR = -2;

    /**
     * Failed to write to the stream.
     *
     * @var integer
     */
    public const WRITING_ERROR = -3;

    /**
     * Failed to read from the stream.
     *
     * @var integer
     */
    public const READING_ERROR = -4;

    /**
     * Failed to send to the stream.
     *
     * @var integer
     */
    public const SENDING_ERROR = -5;

    /**
     * Stream is open.
     *
     * @var integer
     */
    public const OPEN = 1;

    /**
     * Stream is open but busy.
     *
     * @var integer
     */
    public const BUSY = 2;
}
