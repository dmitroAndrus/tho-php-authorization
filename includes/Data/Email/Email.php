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

/**
 * Email is a class to manipulate email data.
 */
class Email implements EmailInterface
{
    use EmailTrait;

    /**
     * Email type.
     *
     * Possible types: personal, work, private, etc.
     *
     * @var string
     */
    protected $emailType;

    /**
     * {@inheritdoc}
     */
    public function setEmailType($type)
    {
        $this->emailType = $type;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmailType()
    {
        return $this->emailType;
    }

    /**
     * {@inheritdoc}
     */
    public function isEmailType($type)
    {
        return $this->getEmailType() === $type;
    }
}
