<?php

/**
 * This file contains HasBCCReceiversInterface interface.
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
 * HasBCCReceiversInterface is an interface, it declares a possibility to access to multiple BCC receivers emails data.
 *
 * Used to store/manage Email Blind copy receivers:
 * * Blind Carbon Copy or "BCC" indicates that the recipient also received a "copy" of an email
 * that was sent to another recipient, however, the recipients do not know to who the email was copied.
 * * The BCC recipient's email address is not visible to the other recipients.
 *
 * Be aware! Some mail services may show BCC receivers to all recipients.
 */
interface HasBCCReceiversInterface
{
    /**
     * Add BCC receiver email.
     *
     * @param string $email Receiver email.
     * @param string $name Receiver name.
     *
     * @return self
     */
    public function addBCCReceiver($email, $name = null);

    /**
     * Has BCC receivers.
     *
     * @return boolean
     */
    public function hasBCCReceivers();

    /**
     * Get BCC receivers.
     *
     * @return array
     */
    public function getBCCReceivers();

    /**
     * Get BCC receivers emails.
     *
     * @return array
     */
    public function getBCCReceiversEmails();

    /**
     * Get BCC receivers names.
     *
     * @return array
     */
    public function getBCCReceiversNames();
}
