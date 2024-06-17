<?php

/**
 * This file contains EmailsTrait trait.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Email;

use ThoPHPAuthorization\Data\Email\EmailInterface;

/**
 * EmailsTrait is a trait, it contains basic methods to manipulate multiple emails data.
 *
 * Implements everything from {@see \ThoPHPAuthorization\Data\Email\HasEmailsInterface}.
 */
trait EmailsTrait
{
    /**
     * Emails.
     *
     * @var EmailInterface[]
     */
    protected $emails = [];

    /**
     * Add email.
     *
     * @param mixed $email Email.
     *
     * @return self
     */
    public function addEmail($email)
    {
        if ($email instanceof EmailInterface) {
            $this->emails[] = $email;
        }
        return $this;
    }

    /**
     * Get all emails.
     *
     * @return EmailInterface[]|null List of all available emails or null when none found.
     */
    public function getEmails()
    {
        return empty($this->emails) ? null : $this->emails;
    }

    /**
     * Get all emails with specified email type.
     *
     * Possible types: personal, work, private, etc.
     *
     * @param string $type - Email type.
     *
     * @return EmailInterface[]|null List of all emails with specified email type or null when none found.
     */
    public function getEmailsByType($type)
    {
        $emails = [];
        foreach ($this->emails as $email) {
            if ($email->isOfType($type)) {
                $emails[] = $email;
            }
        }
        return empty($emails) ? null : $emails;
    }

    /**
     * Get first email with specified email type.
     *
     * Possible types: personal, work, private, etc.
     *
     * @param string $type Email type.
     *
     * @return EmailInterface|null Email object or null when none found.
     */
    public function getFirstEmailByType($type)
    {
        foreach ($this->emails as $email) {
            if ($email->isOfType($type)) {
                return $email;
            }
        }
        return null;
    }

    /**
     * Has atleast one email with specified email type.
     *
     * Possible types: personal, work, private, etc.
     *
     * @param string $type Email type.
     *
     * @return boolean
     */
    public function hasEmailType($type)
    {
        foreach ($this->emails as $email) {
            if ($email->isOfType($type)) {
                return true;
            }
        }
        return false;
    }
}
