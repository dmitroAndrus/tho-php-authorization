<?php

/**
 * This file contains MailTransportInterface interface.
 * PHP version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Mail;

use ThoPHPAuthorization\Mail\MailInterface;

/**
 * MailTransportInterface is an interface, it declares a possibility to send emails.
 */
interface MailTransportInterface
{
    /**
     * Mail transport is available.
     *
     * @return boolean
     */
    public function isAvailable();

    /**
     * Create MailInterface mail object.
     *
     * @param array|MailInterface $mail Mail data.
     *
     * @return MailInterface|null
     */
    public function createMail($mail);

    /**
     * Check if it can handle such mail.
     *
     * It doesn't do $mail validation,
     * it only checks if such $mail type is supported by this mail transport.
     *
     * @param MailInterface $mail Mail to validate.
     *
     * @return boolean Mail is supported or not.
     */
    public function canHandleMail(MailInterface $mail);

    /**
     * Validate mail.
     *
     * Validate mail sender, receiver, replier, etc.
     *
     * @param MailInterface $mail Mail to validate.
     *
     * @return boolean Validation result.
     */
    public function validate(MailInterface $mail);

    /**
     * Create mail message.
     *
     * @param MailInterface $mail Mail to send.
     *
     * @return string Mail message text.
     */
    public function createMailMessage(MailInterface $mail);

    /**
     * Send mail.
     *
     * @param MailInterface $mail Mail to send.
     *
     * @return boolean Mail sending result.
     */
    public function send(MailInterface $mail);
}
