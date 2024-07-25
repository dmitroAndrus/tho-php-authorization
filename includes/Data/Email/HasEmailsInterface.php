<?php

/**
 * This file contains HasEmailsInterface interface.
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
 * HasEmailsInterface is an interface, it declares a possibility to access multiple emails data.
 */
interface HasEmailsInterface
{
    /**
     * Set emails.
     *
     * @param EmailInterface[]|mixed $emails Emails list.
     *
     * @return self
     */
    public function setEmails($emails);

    /**
     * Add emails.
     *
     * @param EmailInterface[]|mixed $emails Emails list.
     *
     * @return self
     */
    public function addEmails($emails);

    /**
     * Add email.
     *
     * @param mixed $email Email.
     *
     * @return self
     */
    public function addEmail($email);

    /**
     * Get all emails.
     *
     * @return EmailInterface[]|null List of all available emails or null when none found.
     */
    public function getEmails();

    /**
     * Get all emails with specified email type.
     *
     * Possible types: personal, work, private, etc.
     *
     * @param string $type Email type.
     *
     * @return EmailInterface[]|null List of all emails with specified email type or null when none found.
     */
    public function getEmailsByType($type);

    /**
     * Get first email with specified email type.
     *
     * Possible types: personal, work, private, etc.
     *
     * @param string $type Email type.
     *
     * @return EmailInterface|null Email object or null when none found.
     */
    public function getFirstEmailByType($type);

    /**
     * Has atleast one email with specified email type.
     *
     * Possible types: personal, work, private, etc.
     *
     * @param string $type Email type.
     *
     * @return boolean
     */
    public function hasEmailType($type);
}
