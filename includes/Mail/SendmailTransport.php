<?php

/**
 * This file contains SendmailTransport class.
 * PHP version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Mail;

use ThoPHPAuthorization\Mail\AbstractSendableMailTransport;
use ThoPHPAuthorization\Mail\MailInterface;

/**
 * SendmailTransport is a class, that is used to send email via sendmail.
 */
class SendmailTransport implements AbstractSendableMailTransport
{
    /**
     * Sendmail additional parameters.
     *
     * The additional parameters parameter can be used to pass additional flags as command
     * line options to the program configured to be used when sending mail,
     * as defined by the sendmail_path configuration setting.
     *
     * For example, this can be used to set the envelope sender address
     * when using sendmail with the -f sendmail option.
     *
     * @var string
     */
    protected $params;

    /**
     * Constructor.
     *
     * @param Array|string $config Sendmail configuration, or string with additional parameters.
     *
     * @return void
     */
    public function __construct($config)
    {
        if (is_array($config)) {
            if (isset($config['params'])) {
                $this->params = $config['params'];
            }
        } elseif (is_string($config)) {
            $this->params = $config['params'];
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function sendRaw(MailInterface $mail, $message, $headers)
    {
        // Set to and subject.
        $to = $headers['To'];
        $subject = $headers['Subject'];
        // Remove unwanted headers.
        unset($headers['To']);
        unset($headers['Subject']);

        return mail($to, $subject, $message, $headers, $this->params ? $this->params : '');
    }
}
