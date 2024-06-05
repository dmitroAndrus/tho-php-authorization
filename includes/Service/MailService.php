<?php

/**
 * This file contains MailService class.
 * PHP version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Service;

use ThoPHPAuthorization\Mail\MailTransportInterface;
use ThoPHPAuthorization\Mail\MailInterface;
use ThoPHPAuthorization\Mail\SendmailTransport;
use ThoPHPAuthorization\Mail\SMTPTransport;

/**
 * MailService is a class, that contains methods to validate and send emails.
 */
class MailService
{
    /**
     * Pattern to validate email.
     *
     * @var string
     * @see https://www.regular-expressions.info/email.html
     */
    public static $emailPattern = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*'
        . '@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';

    /**
     * Validate generic email.
     *
     * @see https://www.regular-expressions.info/email.html
     *
     * @param string $email - Email.
     *
     * @return boolean Email is valid or not.
     */
    public static function validate($email)
    {
        return is_string($email) && !empty($email)
            && preg_match(static::$emailPattern, $email);
    }

    /**
     * Default transport name.
     *
     * @var string|MailTransportInterface
     */
    protected $defaultTransport;

    /**
     * Mail transports.
     *
     * @var MailTransportInterface[]
     */
    protected $transports = [];

    /**
     * Add transport.
     *
     * @param string $name - Transport name.
     * @param array|MailTransportInterface|null $transport - Transport config, MailTransportInterface instance or null.
     * @param boolean $is_default - Set provided transport as default.
     *
     * @return self
     */
    public function addTransport(string $name, $transport = null, $is_default = false)
    {
        $mail_transport = null;
        if ($transport instanceof MailTransportInterface) {
            $mail_transport = $transport;
        } else {
            switch ($name) {
                case 'smtp':
                case 'SMTP':
                    $mail_transport = new SMTPTransport($transport);
                    break;
                case 'sendmail':
                case 'mail':
                    $mail_transport = new SendmailTransport($transport);
                    break;
            }
        }
        if (!is_null($mail_transport)) {
            $this->transports[$name] = $mail_transport;
            if ($is_default) {
                $this->setDefaultTransport($name);
            }
        }
        return $this;
    }

    /**
     * Send mail with default transport.
     *
     * @param string|MailTransportInterface $transport - Transport name or MailTransportInterface instance.
     *
     * @return MailTransportInterface|null.
     */
    public function getTransport($transport)
    {
        if ($transport instanceof MailTransportInterface) {
            return $transport;
        } elseif (is_string($transport) && isset($this->transports[$transport])) {
            return $this->transports[$transport];
        }
        return null;
    }

    /**
     * Set default transport.
     *
     * @param string|MailTransportInterface $transport - Default transport name or MailTransportInterface instance.
     *
     * @return self
     */
    public function setDefaultTransport($transport)
    {
        if ($transport instanceof MailTransportInterface) {
            $this->defaultTransport = $transport;
        } elseif (is_string($transport)) {
            $this->defaultTransport = $transport;
        } else {
            $this->defaultTransport = null;
        }
        return $this;
    }

    /**
     * Send mail with default transport.
     *
     * @param array|MailInterface $mail - Mail to send.
     *
     * @return boolean Mail sending result.
     */
    public function send($mail)
    {
        $transport = $this->getTransport($this->defaultTransport);
        if (!($transport && $transport->isAvailable())) {
            return false;
        }
        $mail = $transport->createMail($mail);
        return ($mail instanceof MailInterface)
            && $transport->send($mail);
    }

    /**
     * Send mail with specified transport.
     *
     * @param string $name - Mail transport name.
     * @param array|MailInterface $mail - Mail to send.
     *
     * @return boolean Mail sending result.
     */
    public function sendBy(string $name, $mail)
    {
        $transport = $this->getTransport($name);
        if (!($transport && $transport->isAvailable())) {
            return false;
        }
        $mail = $transport->createMail($mail);
        return ($mail instanceof MailInterface)
            && $transport->send($mail);
    }
}
