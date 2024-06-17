<?php

/**
 * This file contains AbstractSendableMailTransport class.
 * PHP version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Mail;

use ThoPHPAuthorization\Mail\MailTransportInterface;
use ThoPHPAuthorization\Mail\AbstractMailTransport;
use ThoPHPAuthorization\Mail\MailInterface;
use ThoPHPAuthorization\Service\MailService;
use ThoPHPAuthorization\Data\Email\HasReceiverInterface;
use ThoPHPAuthorization\Data\Email\HasReceiversInterface;
use ThoPHPAuthorization\Data\Email\HasReplyToInterface;
use ThoPHPAuthorization\Data\Email\HasSenderInterface;
use ThoPHPAuthorization\Data\Email\HasCCReceiversInterface;
use ThoPHPAuthorization\Data\Email\HasBCCReceiversInterface;
use ThoPHPAuthorization\Data\File\HasAttachmentsInterface;
use ThoPHPAuthorization\Data\File\LocalFileInterface;

/**
 * AbstractSendableMailTransport is an abstract class, that implements basic MailTransportInterface methods.
 */
abstract class AbstractSendableMailTransport extends AbstractMailTransport
{
    /**
     * Default text for HTML mail.
     *
     * This text will be shown when email receiver's software doesn't support HTML emails.
     *
     * @var string
     */
    public static $defaultHTMLMailtext = "This is a HTML email and unfortunately
        your email client software doesn\'t support HTML emails!";

    /**
     * Strict mail validation.
     *
     * When $strict = false it will check if atleast one receiver email is valid,
     * otherwise mail data will be checked strictly.
     *
     * @var boolean
     */
    public static $strictMail = false;

    /**
     * Mail new line.
     *
     * @var string
     */
    public static $newline = "\n";

    /**
     * {@inheritdoc}
     */
    public function canHandleMail(MailInterface $mail)
    {
        // Sendable mail should have receiver(s).
        return ($mail instanceof HasReceiverInterface) || ($mail instanceof HasReceiversInterface);
    }

    /**
     * {@inheritdoc}
     */
    public function validate(MailInterface $mail)
    {
        // Do validation from parent class.
        if (!parent::validate($mail)) {
            return false;
        }
        // Validate receiver(s).
        if ($mail instanceof HasReceiverInterface) {
            if (!$this->validateEmailData($mail->getReceiver())) {
                return false;
            }
        } elseif ($mail instanceof HasReceiversInterface && $mail->hasReceivers()) {
            $has_receiver = false;
            foreach ($mail->getReceivers() as $receiver) {
                if ($this->validateEmailData($receiver)) {
                    $has_receiver = true;
                } else {
                    // When strict all receivers should be valid.
                    return false;
                }
            }
            if (!$has_receiver) {
                return false;
            }
        } else {
            // Email should have receivers.
            return false;
        }
        // Check reply to email if it's available.
        if ($mail instanceof HasReplyToInterface) {
            if ($mail->hasReplyTo() && !$this->validateEmailData($mail->getReplyTo())) {
                return false;
            }
        }
        // Check sender email if it's available.
        if ($mail instanceof HasSenderInterface) {
            if ($mail->hasSender() && !$this->validateEmailData($mail->getSender())) {
                return false;
            }
        }
        // Check CC receivers emails.
        if ($mail instanceof HasCCReceiversInterface && $mail->hasCCReceivers()) {
            foreach ($mail->getCCReceivers() as $receiver) {
                if (!$this->validateEmailData($receiver)) {
                    return false;
                }
            }
        }
        // Check BCC receivers emails.
        if ($mail instanceof HasBCCReceiversInterface && $mail->hasBCCReceivers()) {
            foreach ($mail->getBCCReceivers() as $receiver) {
                if (!$this->validateEmailData($receiver)) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Create mail attachment message.
     *
     * Please ensure that $mail is valid before creating message.
     *
     * @param LocalFileInterface $file Attachment file.
     * @param string $boundary Boundary.
     *
     * @return string|null Message or null when failed
     */
    public function createAttachmentMessage($file, $boundary)
    {
        $message = null;
        if ($file instanceof LocalFileInterface) {
            $content = $file->getContent();
            if ($content) {
                $basename = $file->getBaseName();
                $message = '--' . $boundary . static::$newline;
                $message .= 'Content-Type: application/octet-stream; name="' . $basename . '"'
                    . static::$newline;
                $message .= 'Content-Transfer-Encoding: base64' . static::$newline;
                $message .= 'Content-Disposition: attachment; filename="' . $basename . '"' . static::$newline;
                $message .= 'Content-ID: <' . urlencode($basename) . '>' . static::$newline;
                $message .= 'X-Attachment-Id: ' . urlencode($basename) . static::$newline . static::$newline;
                $message .= chunk_split(base64_encode($content));
            }
        }
        return $message;
    }

    /**
     * Create mail attachments message.
     *
     * Please ensure that $mail is valid before creating message.
     *
     * @param MailInterface $mail Mail object.
     * @param string $boundary Boundary.
     *
     * @return string|null Message or null when failed.
     */
    public function createAttachmentsMessage(MailInterface $mail, $boundary)
    {
        if (!($mail instanceof HasAttachmentsInterface)) {
            return null;
        }
        $message = '';
        foreach ($mail->getAttachments() as $file) {
            $attachment = $this->createAttachmentMessage($file, $boundary);
            if ($attachment) {
                $message .= $attachment;
            }
        }
        return $message
            ? $message
            : null;
    }

    /**
     * Create text mail message.
     *
     * Please ensure that $mail is valid before creating message.
     *
     * @param MailInterface $mail Mail object.
     * @param string $boundary Boundary.
     *
     * @return string|null Message or null when failed.
     */
    public function createTextMessage(MailInterface $mail, $boundary)
    {
        // Main message content.
        $newline = static::$newline;
        $message = '--' . $boundary . static::$newline;
        $message .= 'Content-Type: text/plain; charset="utf-8"' . static::$newline;
        $message .= 'Content-Transfer-Encoding: 8bit' . static::$newline . static::$newline;
        $message .= $mail->getText() . static::$newline;

        // Try to add attachments.
        if ($mail instanceof HasAttachmentsInterface && $mail->hasAttachments()) {
            $attachments = $this->createAttachmentsMessage($mail, $boundary);
            if (!empty($attachments)) {
                $message .= $attachments;
            }
        }

        // Message end.
        $message .= '--' . $boundary . '--' . static::$newline;
        return $message;
    }

    /**
     * Create HTML mail message.
     *
     * Please ensure that $mail is valid before creating message.
     *
     * @param MailInterface $mail Mail object.
     * @param string $boundary Boundary.
     *
     * @return string|null Message or null when failed.
     */
    public function createHTMLMessage(MailInterface $mail, $boundary)
    {
        // Add text message.
        $message  = '--' . $boundary . static::$newline;
        $message .= 'Content-Type: multipart/alternative; boundary="' . $boundary . '_alt"'
            . static::$newline . static::$newline;
        $message .= '--' . $boundary . '_alt' . static::$newline;
        $message .= 'Content-Type: text/plain; charset="utf-8"' . static::$newline;
        $message .= 'Content-Transfer-Encoding: 8bit' . static::$newline . static::$newline;

        $text = $mail->getText();
        if (empty($text)) {
            $message .= static::$defaultHTMLMailtext . static::$newline;
        } else {
            $message .= $text . static::$newline;
        }

        $message .= '--' . $boundary . '_alt' . static::$newline;
        $message .= 'Content-Type: text/html; charset="utf-8"' . static::$newline;
        $message .= 'Content-Transfer-Encoding: 8bit' . static::$newline . static::$newline;
        $message .= $mail->getHTML() . static::$newline;
        $message .= '--' . $boundary . '_alt--' . static::$newline;

        // Try to add attachments.
        if ($mail instanceof HasAttachmentsInterface && $mail->hasAttachments()) {
            $attachments = $this->createAttachmentsMessage($mail, $boundary);
            if (!empty($attachments)) {
                $message .= $attachments;
            }
        }

        // Message end.
        $message .= '--' . $boundary . '--' . static::$newline;
        return $message;
    }

    /**
     * Create mail message.
     *
     * Please ensure that $mail is valid before creating message.
     *
     * @param MailInterface $mail Mail object.
     * @param string $boundary Boundary.
     *
     * @return string|null Message or null when failed.
     */
    public function createMessage(MailInterface $mail, $boundary)
    {
        switch (static::$mailType) {
            case static::MAIL_TYPE_TEXT_OR_HTML:
                if ($mail->hasHTML()) {
                    return $this->createHTMLMessage($mail, $boundary);
                }
                return $this->createTextMessage($mail, $boundary);
            case static::MAIL_TYPE_TEXT_ONLY:
                return $this->createTextMessage($mail, $boundary);
            case static::MAIL_TYPE_HTML_ONLY:
                return $this->createHTMLMessage($mail, $boundary);
        }
        return null;
    }

    /**
     * Get From email address from the mail object.
     *
     * @param MailInterface $mail Mail object.
     *
     * @return string|null If email is valid - return email, otherwise - null.
     */
    public function getFromEmail(MailInterface $mail)
    {
        return $this->getValidEmail($mail->getFromEmail());
    }

    /**
     * Get all receivers email addresses from the mail object.
     *
     * @param MailInterface $mail Mail object.
     *
     * @return string[]|null List of valid emails or null.
     */
    public function getAllReceiversEmails(MailInterface $mail)
    {
        $receivers = [];
        if ($mail instanceof HasReceiversInterface) {
            // Handle multiple receivers.
            $emails = $this->filterValidEmails($mail->getReceiversEmails());
            if (!empty($emails)) {
                array_push($receivers, ...$emails);
            }
        } else {
            // Handle single receiver.
            $email = $this->getValidEmail($mail->getReceiverEmail());
            if ($email) {
                $receivers[] = $email;
            }
        }
        // Check CC receivers emails.
        if ($mail instanceof HasCCReceiversInterface && $mail->hasCCReceivers()) {
            $emails = $this->filterValidEmails($mail->getCCReceiversEmails());
            if (!empty($emails)) {
                array_push($receivers, ...$emails);
            }
        }
        // Check BCC receivers emails.
        if ($mail instanceof HasBCCReceiversInterface && $mail->hasBCCReceivers()) {
            $emails = $this->filterValidEmails($mail->getBCCReceiversEmails());
            if (!empty($emails)) {
                array_push($receivers, ...$emails);
            }
        }
        return empty($receivers) ? null : $receivers;
    }

    /**
     * Create mail headers.
     *
     * Please ensure that $mail is valid before creating message.
     *
     * @param MailInterface $mail Mail object.
     * @param string $boundary Boundary.
     *
     * @return array|null Mail headers or null when failed.
     */
    public function createHeaders(MailInterface $mail, $boundary)
    {
        $headers = [];
        $headers['mime-version'] = 'MIME-Version: 1.0';
        if ($mail instanceof HasReceiversInterface) {
            // Handle multiple receivers.
            $headers['To'] = $this->formatEmailsData($mail->getReceiver());
        } else {
            $headers['To'] = $this->formatEmailData($mail->getReceiver());
        }
        $headers['Subject'] = $this->formatMailText($mail->getSubject());
        $headers['Date'] = date('D, d M Y H:i:s O');

        $headers['From'] = $this->formatEmailData($mail->getFrom());

        // Check reply to email if it's available.
        if ($mail instanceof HasReplyToInterface && $mail->hasReplyTo()) {
            $email = $this->formatEmailData($mail->getReplyTo());
            if ($email) {
                $headers['Reply-To'] = $email;
            }
        }

        // Check sender email if it's available.
        if ($mail instanceof HasSenderInterface && $mail->hasSender()) {
            $email = $this->formatEmailData($mail->getSender());
            if ($email) {
                $headers['Sender'] = $email;
                $headers['X-Sender'] = $email;
            }
        }
        // Check CC receivers emails.
        if ($mail instanceof HasCCReceiversInterface && $mail->hasCCReceivers()) {
            $emails = $this->formatEmailsData($mail->getCCReceivers());
            if (!empty($emails)) {
                $headers['Cc'] = $emails;
            }
        }
        // Check BCC receivers emails.
        if ($mail instanceof HasBCCReceiversInterface && $mail->hasBCCReceivers()) {
            $emails = $this->formatEmailsData($mail->getBCCReceivers());
            if (!empty($emails)) {
                $headers['Bcc'] = $emails;
            }
        }

        $headers['X-Mailer'] = 'PHP/' . phpversion();
        $headers['Content-Type'] = 'multipart/related; boundary="' . $boundary . '"';
        return $headers;
    }

    /**
     * Join headers array.
     *
     * @param array $headers Headers.
     *
     * @return string|null Mail headers or null.
     */
    public function joinHeaders($headers)
    {
        if (is_string($headers)) {
            return $headers;
        }
        $parts = [];
        foreach ($headers as $name => $value) {
            $parts[] = $name . ': ' . $value;
        }
        return empty($parts)
            ? null
            : implode(static::$newline, $parts);
    }

    /**
     * {@inheritdoc}
     */
    public function createMailMessage(MailInterface $mail)
    {
        if ($this->validate($mail)) {
            $boundary = '----=_NextPart_' . md5(time());
            $message = $this->createMessage($mail, $boundary);
            $headers = $this->createHeaders($mail, $boundary);
            $mail_msg = '';
            if (!empty($headers)) {
                $mail_msg .= $this->joinHeaders($headers);
            }
            if (!empty($message)) {
                if (!empty($mail_msg)) {
                    $mail_msg .= static::$newline . static::$newline;
                }
                $mail_msg .= $message;
            }
            if (!empty($mail_msg)) {
                return $mail_msg;
            }
        }
        return null;
    }

    /**
     * Send raw mail.
     *
     * @param MailInterface $mail Mail object.
     * @param mixed $message Mail message.
     * @param mixed $headers Mail headers.
     *
     * @return boolean Mail sending result.
     */
    abstract protected function sendRaw(MailInterface $mail, $message, $headers);

    /**
     * {@inheritdoc}
     */
    public function send(MailInterface $mail)
    {
        if ($this->validate($mail)) {
            $boundary = '----=_NextPart_' . md5(time());
            $message = $this->createMessage($mail, $boundary);
            $headers = $this->createHeaders($mail, $boundary);
            if (!(empty($message) || empty($headers))) {
                return $this->sendRaw($mail, $message, $headers);
            }
        }
        return false;
    }
}
