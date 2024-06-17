<?php

/**
 * This file contains SMTPStreamInterface interface.
 * PHP version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Stream;

use ThoPHPAuthorization\Stream\StreamInterface;

/**
 * SMTPStreamInterface is an interface, that contains basic methods to work with SMTP server stream.
 */
interface SMTPStreamInterface extends StreamInterface
{
    /**
     * Send mail.
     *
     * @param string $from_email From email address.
     * @param string|string[] $receiver_email Single or all receivers email addresses, including CC and BCC receivers.
     * @param string $message Mail message.
     * @param string|string[]|null $headers Additional mail headers.
     *
     * @return string File content.
     */
    public function sendMail($from_email, $receiver_email, $message, $headers = null);
}
