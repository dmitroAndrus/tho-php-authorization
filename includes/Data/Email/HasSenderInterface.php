<?php

/**
 * This file contains HasSenderInterface interface.
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
 * HasSenderInterface is an interface, it declares a possibility to access to the sender email data.
 */
interface HasSenderInterface
{
    /**
     * Set sender email.
     *
     * @param string $email - Sender email.
     * @param string $name - Sender name.
     *
     * @return self.
     */
    public function setSender($email, $name = null);

    /**
     * Has sender.
     *
     * @return boolean.
     */
    public function hasSender();

    /**
     * Get sender.
     *
     * [
     *  'name' => 'Name',
     *  'email' => 'email@mail.com'
     * ]
     *
     * @return array.
     */
    public function getSender();

    /**
     * Get sender email.
     *
     * @return string.
     */
    public function getSenderEmail();

    /**
     * Get sender name.
     *
     * @return string.
     */
    public function getSenderName();
}
