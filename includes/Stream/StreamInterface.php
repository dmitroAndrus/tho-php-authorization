<?php

/**
 * This file contains StreamInterface interface.
 * PHP version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Stream;

/**
 * StreamInterface is an interface, that contains basic methods to work with stream.
 */
interface StreamInterface
{
    /**
     * Try to open stream.
     *
     * @param boolean $force - Try to forcefuly open/reopen stream.
     *
     * @return boolean - Stream opening status.
     */
    public function open($force = false);

    /**
     * Close stream.
     *
     * @param boolean $force - Try to forcefuly close stream.
     *
     * @return boolean - Stream close status.
     */
    public function close($force = false);

    /**
     * Check if stream is open.
     *
     * @return boolean.
     */
    public function isOpen();

    /**
     * Check if stream is closed.
     *
     * @return boolean.
     */
    public function isClosed();

    /**
     * Get stream status.
     *
     * @return mixed - Stream status.
     */
    public function getStatus();
}
