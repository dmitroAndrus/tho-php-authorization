<?php

/**
 * This file contains HasReplyToInterface interface.
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
 * HasReplyToInterface is an interface, it declares a possibility to access to the reply to email data.
 */
interface HasReplyToInterface
{
    /**
     * Set reply to email.
     *
     * @param string $email Reply to email.
     * @param string $name Reply to name.
     *
     * @return self
     */
    public function setReplyTo($email, $name = null);

    /**
     * Has reply to.
     *
     * @return boolean
     */
    public function hasReplyTo();

    /**
     * Get reply to.
     *
     * Returns:
     * ```php
     * [
     *  'name' => 'Name',
     *  'email' => 'email@mail.com'
     * ]
     * ```
     *
     * @return array
     */
    public function getReplyTo();

    /**
     * Get reply to name.
     *
     * @return string
     */
    public function getReplyToName();

    /**
     * Get reply to email.
     *
     * @return string
     */
    public function getReplyToEmail();
}
