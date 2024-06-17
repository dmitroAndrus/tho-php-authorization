<?php

/**
 * This file contains HasReceiversInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Email;

/**
 * HasReceiversInterface is an interface, it declares a possibility to access to multiple receivers emails data.
 */
interface HasReceiversInterface
{
    /**
     * Add receiver email.
     *
     * @param string $email Receiver email.
     * @param string $name Receiver name.
     *
     * @return self
     */
    public function addReceiver($email, $name = null);

    /**
     * Has receivers.
     *
     * @return boolean
     */
    public function hasReceivers();

    /**
     * Get receivers.
     *
     * @return array
     */
    public function getReceivers();

    /**
     * Get receivers emails.
     *
     * @return array
     */
    public function getReceiversEmails();

    /**
     * Get receivers names.
     *
     * @return array
     */
    public function getReceiversNames();
}
