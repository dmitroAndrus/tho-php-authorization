<?php

/**
 * This file contains MailInterface interface.
 * PHP version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Mail;

use ThoPHPAuthorization\Data\Email\HasFromInterface;

/**
 * MailInterface is an interface, it declares that it's a mail with basic mail properties.
 */
interface MailInterface extends HasFromInterface
{
    /**
     * Set mail subject.
     *
     * @param string $subject - Email subject.
     *
     * @return self.
     */
    public function setSubject($subject);

    /**
     * Get mail subject.
     *
     * @return string.
     */
    public function getSubject();

    /**
     * Set mail text.
     *
     * @param string $text - Email text.
     *
     * @return self.
     */
    public function setText($text);

    /**
     * Get mail text.
     *
     * @return string.
     */
    public function getText();

    /**
     * Set mail HTML.
     *
     * @param string $html - Email HTML.
     *
     * @return self.
     */
    public function setHTML($html);

    /**
     * Get mail html.
     *
     * @return string.
     */
    public function getHTML();

    /**
     * Has mail html.
     *
     * @return boolean.
     */
    public function hasHTML();
}
