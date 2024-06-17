<?php

/**
 * This file contains EmailTrait trait.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Email;

use ThoPHPAuthorization\Service\TemplatingService;

/**
 * EmailTrait is a trait, it contains basic methods to manipulate address data.
 *
 * Implements everything from {@see \ThoPHPAuthorization\Data\Email\HasEmailInterface}.
 */
trait EmailTrait
{
    /**
     * Email.
     *
     * @var string
     */
    protected $email;

    /**
     * Set email.
     *
     * @param string $email Email.
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
