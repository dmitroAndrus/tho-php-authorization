<?php

/**
 * This file contains Email class.
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
use ThoPHPAuthorization\Data\Email\EmailTrait;
use ThoPHPAuthorization\Data\Type\TypeTrait;

/**
 * Email is a class to manipulate email data.
 *
 * Provides access to email and email type data.
 * Possible email types: personal, work, private, etc.
 */
class Email implements EmailInterface
{
    use EmailTrait;
    use TypeTrait;

    /**
     * Get a string representation of the object.
     *
     * @return string.
     */
    public function __toString()
    {
        $email = $this->getEmail();
        return $email ? (string) $email : '';
    }
}
