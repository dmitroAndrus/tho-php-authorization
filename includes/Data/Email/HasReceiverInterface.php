<?php

/**
 * This file contains HasReceiverInterface interface.
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
 * HasReceiverInterface is an interface, it declares a possibility to access to the receiver email data.
 */
interface HasReceiverInterface
{
    /**
     * Set receiver email.
     *
     * @param string $email Receiver email.
     * @param string $name Receiver name.
     *
     * @return self
     */
    public function setReceiver($email, $name = null);

    /**
     * Has receiver.
     *
     * @return boolean
     */
    public function hasReceiver();

    /**
     * Get receiver.
     *
     * Returns:
     * ```php
     * [
     *  'name' => 'Name',
     *  'email' => 'email@mail.com'
     * ]
     * ```
     *
     * @return array
     */
    public function getReceiver();

    /**
     * Get receiver name.
     *
     * @return string
     */
    public function getReceiverName();

    /**
     * Get receiver email.
     *
     * @return string
     */
    public function getReceiverEmail();
}
