<?php

/**
 * This file contains EmailInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Email;

use ThoPHPAuthorization\Data\Email\HasEmailInterface;

/**
 * EmailInterface is an interface to maintain and manipulate email data.
 */
interface EmailInterface extends HasEmailInterface
{
    /**
     * Set email type.
     *
     * Type of email: personal, work, private, etc.
     *
     * @param string $type - Email type.
     *
     * @return self.
     */
    public function setEmailType($type);

    /**
     * Get email type.
     *
     * Type of email: home, personal, work, private, etc.
     *
     * @return string.
     */
    public function getEmailType();

    /**
     * Check email type.
     *
     * Type of email: personal, work, private, etc.
     *
     * @param string $type - Email type.
     *
     * @return boolean.
     */
    public function isEmailType($type);
}
