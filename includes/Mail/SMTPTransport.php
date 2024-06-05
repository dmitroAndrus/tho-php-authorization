<?php

/**
 * This file contains SMTPTransport class.
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
use ThoPHPAuthorization\Stream\SMTPStreamInterface;
use ThoPHPAuthorization\Stream\FsockSMTPStream;

/**
 * SMTPTransport is a class, that is used to send email via SMTP.
 */
class SMTPTransport extends AbstractSendableMailTransport
{
    /**
     * SMTP stream.
     *
     * @var SMTPStreamInterface
     */
    protected $stream;

    /**
     * SMTP stream availability.
     *
     * @var boolean.
     */
    protected $streamAvailable = null;

    /**
     * Constructor.
     *
     * @param array|SMTPStreamInterface $smtp - SMTP stream or configuration for FsockSMTPStream.
     *
     * @return void
     */
    public function __construct($smtp = null)
    {
        if ($smtp instanceof SMTPStreamInterface) {
            $this->stream = $smtp;
        } else {
            $this->stream = FsockSMTPStream::create($smtp);
        }
    }

    /**
     * Check if stream is available.
     *
     * @return boolean.
     */
    protected function checkStream()
    {
        if (!$this->stream) {
            return false;
        }
        if ($this->stream->isOpen()) {
            return true;
        }
        $result = $this->stream->open();
        $this->stream->close(true);
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailable()
    {
        if (is_null($this->streamAvailable)) {
            $this->streamAvailable = $this->checkStream();
        }
        return $this->streamAvailable;
    }

    /**
     * {@inheritdoc}
     */
    protected function sendRaw(MailInterface $mail, $message, $headers)
    {
        // Connect to SMTP and authorize.
        if (!$this->stream->open()) {
            return false;
        }
        $result = $this->stream->sendMail(
            $this->getFromEmail($mail),
            $this->getAllReceiversEmails($mail),
            $message,
            $headers
        );
        // Forcefully close stream.
        $this->stream->close(true);
        return $result;
    }
}
