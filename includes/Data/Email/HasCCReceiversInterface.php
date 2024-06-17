<?php

/**
 * This file contains HasCCReceiversInterface interface.
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
 * HasCCReceiversInterface is an interface, it declares a possibility to access to multiple CC receivers emails data.
 *
 * Used to store/manage mail copy receivers.
 */
interface HasCCReceiversInterface
{
    /**
     * Add CC receiver email.
     *
     * @param string $email Receiver email.
     * @param string $name Receiver name.
     *
     * @return self
     */
    public function addCCReceiver($email, $name = null);

    /**
     * Has CC receivers.
     *
     * @return boolean
     */
    public function hasCCReceivers();

    /**
     * Get CC receivers.
     *
     * @return array
     */
    public function getCCReceivers();

    /**
     * Get CC receivers emails.
     *
     * @return array
     */
    public function getCCReceiversEmails();

    /**
     * Get CC receivers names.
     *
     * @return array
     */
    public function getCCReceiversNames();
}
