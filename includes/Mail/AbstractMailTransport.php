<?php

/**
 * This file contains AbstractMailTransport class.
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
use ThoPHPAuthorization\Mail\MailInterface;
use ThoPHPAuthorization\Mail\Mail;
use ThoPHPAuthorization\Service\MailService;
use ThoPHPAuthorization\Service\TemplatingService;

/**
 * AbstractMailTransport is an abstract class, that implements basic MailTransportInterface methods.
 */
abstract class AbstractMailTransport implements MailTransportInterface
{
    /**
     * Text or HTML mails.
     *
     * @var integer
     */
    public const MAIL_TYPE_TEXT_OR_HTML = 0;

    /**
     * Only text mails.
     *
     * @var integer
     */
    public const MAIL_TYPE_TEXT_ONLY = 1;

    /**
     * Only HTML mails.
     *
     * @var integer
     */
    public const MAIL_TYPE_HTML_ONLY = 2;

    /**
     * Mail type.
     *
     * Use MAIL_TYPE_<type> constants for refference.
     *
     * @var integer
     */
    public static $mailType = 0;

    /**
     * Minimum email subject lenght.
     *
     * @var integer
     */
    public static $minSubjectLen = 5;

    /**
     * Maximum email subject lenght.
     *
     * @var integer
     */
    public static $maxSubjectLen = 60;

    /**
     * Minimum email name length.
     *
     * @var integer
     */
    public static $minNameLen = 2;

    /**
     * Maximum email name lenght.
     *
     * @var integer
     */
    public static $maxNameLen = 25;

    /**
     * Minimum email text length.
     *
     * @var integer
     */
    public static $minTextLen = 15;

    /**
     * Maximum email text lenght.
     *
     * @var integer
     */
    public static $maxTextLen = null;

    /**
     * {@inheritdoc}
     */
    public function createMail($mail)
    {
        if ($mail instanceof MailInterface) {
            return $mail;
        } elseif (is_array($mail)) {
            return new Mail($mail);
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function canHandleMail(MailInterface $mail)
    {
        return true;
    }

    /**
     * Validate email subject text.
     *
     * @param string $text Mail subject text.
     *
     * @return boolean
     */
    public function validateSubject($text)
    {
        $len = mb_strlen($text);
        return is_string($text)
            && $len >= static::$minSubjectLen
            && $len <= static::$maxSubjectLen;
    }

    /**
     * Validate email name.
     *
     * @param string $name Email name.
     *
     * @return boolean
     */
    public function validateEmailName($name)
    {
        $len = mb_strlen($name);
        return is_string($name)
            && $len >= static::$minNameLen
            && $len <= static::$maxNameLen;
    }

    /**
     * Validate email address.
     *
     * @param string $email Email address.
     *
     * @return boolean
     */
    public function validateEmail($email)
    {
        return MailService::validate($email);
    }

    /**
     * Validate email html.
     *
     * @param string $html Html to validate.
     *
     * @return boolean
     */
    public function validateHTML($html)
    {
        return TemplatingService::validateHTML($html);
    }

    /**
     * Validate email text.
     *
     * @param string $text Text to validate.
     *
     * @return boolean
     */
    public function validateText($text)
    {
        $len = mb_strlen($text);
        return is_string($text)
            && $len >= static::$minTextLen
            && (is_null(static::$maxTextLen) || $len <= static::$maxTextLen);
    }

    /**
     * Validate email data.
     *
     * Data format:
     * ```php
     * [
     *  'name' => 'Name',
     *  'email' => 'email@mail.com'
     * ]
     * ```
     *
     * @param array $data Email data.
     *
     * @return boolean
     */
    public function validateEmailData($data)
    {
        if (!is_array($data)) {
            return false;
        }
        // If there is name - validate it.
        if (isset($data['name']) && !is_null($data['name'])) {
            if (!$this->validateEmailName($data['name'])) {
                return false;
            }
        }
        return isset($data['email']) && $this->validateEmail($data['email']);
    }

    /**
     * Format mail text.
     *
     * Result example:
     * ```
     * ?UTF-8?B?My text?=
     * ```
     *
     * @param string $text Text.
     *
     * @return string Formated mail text.
     */
    public function formatMailText($text)
    {
        return '=?UTF-8?B?' . base64_encode($text) . '?=';
    }

    /**
     * Get valid email.
     *
     * @param string $email Email to validate.
     *
     * @return string|null Valid email or null.
     */
    public function getValidEmail($email)
    {
        return $this->validateEmail($email) ? $email : null;
    }

    /**
     * Filter emails and return valid ones.
     *
     * @param string[] $email Emails to validate.
     *
     * @return string[]|null List of valid email or null.
     */
    public function filterValidEmails($emails)
    {
        if (empty($emails)) {
            return null;
        }
        $valid = [];
        foreach ($emails as $email) {
            if ($this->validateEmail($email)) {
                $valid[] = $email;
            }
        }
        return empty($valid) ? null : $valid;
    }

    /**
     * Format email data.
     *
     * Data format:
     * ```php
     * [
     *  'name' => 'Name',
     *  'email' => 'email@mail.com'
     * ]
     * ```
     * Result examples:
     * ```
     * =?UTF-8?B?My name?= <my@mail.com>
     * ```
     * ```
     * my@mail.com
     * ```
     *
     * @param array $data Email data.
     *
     * @return string|null Formated email string or null.
     */
    public function formatEmailData($data)
    {
        if ($this->validateEmailData($data)) {
            return isset($data['name']) && !is_null($data['name'])
                ? $this->formatMailText($data['name']) . ' <' . $data['email'] . '>'
                : $data['email'];
        }
        return null;
    }

    /**
     * Format multiple emails data.
     *
     * Single email data format:
     * ```php
     * [
     *  'name' => 'Name',
     *  'email' => 'email@mail.com'
     * ]
     * ```
     * Result examples:
     * ```
     * =?UTF-8?B?My name 1?= <my_1@mail.com>, my_2@mail.com, =?UTF-8?B?My name 3?= <my_3@mail.com>
     * ```
     *
     * @param array $emails_data Emails data.
     *
     * @return string|null Formated email string or null.
     */
    public function formatEmailsData($emails_data)
    {
        $emails = [];
        foreach ($emails_data as $data) {
            $formated = $this->formatEmailData($data);
            if (!is_null($formated)) {
                $emails[] = $formated;
            }
        }
        return empty($emails)
            ? null
            : implode(', ', $emails);
    }

    /**
     * Validate mail message.
     *
     * @param MailInterface $mail Mail to validate.
     *
     * @return boolean
     */
    public function validateMessage($mail)
    {
        switch (static::$mailType) {
            case static::MAIL_TYPE_TEXT_OR_HTML:
                if ($mail->hasHTML()) {
                    return $this->validateHTML($mail->getHTML());
                }
                return $this->validateText($mail->getText());
            case static::MAIL_TYPE_TEXT_ONLY:
                return $this->validateText($mail->getText());
            case static::MAIL_TYPE_HTML_ONLY:
                return $this->validateHTML($mail->getHTML());
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(MailInterface $mail)
    {
        // Validate basic data.
        if (
            !(
                $this->validateSubject($mail->getSubject())
                && $this->validateEmailData($mail->getFrom())
                && (!$mail->hasReplyTo() || $this->validateEmailData($mail->getReplyTo()))
            )
        ) {
            return false;
        }
        // Validate mail content.
        if (!$this->validateMessage($mail)) {
            return false;
        }
        return true;
    }
}
