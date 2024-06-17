<?php

/**
 * This file contains HasEmailInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Email;

/**
 * HasEmailInterface is an interface, it declares a possibility to access to the email data.
 */
interface HasEmailInterface
{
    /**
     * Set email.
     *
     * @param string $email Email.
     *
     * @return self
     */
    public function setEmail($email);

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail();
}
