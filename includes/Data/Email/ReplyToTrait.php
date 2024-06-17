<?php

/**
 * This file contains ReplyToTrait trait.
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
 * ReplyToTrait is a trait, it contains basic methods to manipulate sender email data.
 *
 * Implements everything from {@see \ThoPHPAuthorization\Data\Email\HasReplyToInterface}.
 */
trait ReplyToTrait
{
    /**
     * Reply to email.
     *
     * @var string
     */
    protected $replyToName;

    /**
     * Reply to email.
     *
     * @var string
     */
    protected $replyToEmail;

    /**
     * Set reply to email.
     *
     * @param string $email - Reply to email.
     * @param string $name - Reply to name.
     *
     * @return self
     */
    public function setReplyTo($email, $name = null)
    {
        $this->replyToEmail = empty($email)
            ? null
            : $email;
        $this->replyToName = empty($name)
            ? null
            : $name;
        return $this;
    }

    /**
     * Has receiver.
     *
     * @return boolean
     */
    public function hasReplyTo()
    {
        return !is_null($this->replyToEmail);
    }

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
    public function getReplyTo()
    {
        if ($this->hasReplyTo()) {
            $data = [
                'email' => $this->getReplyToEmail(),
            ];
            $name = $this->getReplyToName();
            if (!is_null($name)) {
                $data['name'] = $name;
            }
            return $data;
        }
        return null;
    }

    /**
     * Get reply to email.
     *
     * @return string
     */
    public function getReplyToEmail()
    {
        return $this->replyToEmail;
    }

    /**
     * Get reply to name.
     *
     * @return string
     */
    public function getReplyToName()
    {
        return $this->replyToName;
    }
}
