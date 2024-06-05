<?php

/**
 * This file contains SenderTrait trait.
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
 * SenderTrait is a trait, it contains basic methods to manipulate sender email data.
 *
 * Implements everything from ThoPHPAuthorization\Data\Email\HasSenderInterface.
 */
trait SenderTrait
{
    /**
     * Sender email.
     *
     * @var string
     */
    protected $senderName;

    /**
     * Sender email.
     *
     * @var string
     */
    protected $senderEmail;

    /**
     * Set sender email.
     *
     * @param string $name - Sender name.
     * @param string $email - Sender email.
     *
     * @return self.
     */
    public function setSender($email, $name = null)
    {
        $this->senderEmail = empty($email)
            ? null
            : $email;
        $this->senderName = empty($name)
            ? null
            : $name;
        return $this;
    }

    /**
     * Has sender.
     *
     * @return boolean.
     */
    public function hasSender()
    {
        return !is_null($this->senderEmail);
    }

    /**
     * Get sender.
     *
     * [
     *  'name' => 'Name',
     *  'email' => 'email@mail.com'
     * ]
     *
     * @return array.
     */
    public function getSender()
    {
        if ($this->hasSender()) {
            $data = [
                'email' => $this->getSenderEmail(),
            ];
            $name = $this->getSenderName();
            if (!is_null($name)) {
                $data['name'] = $name;
            }
            return $data;
        }
        return null;
    }

    /**
     * Get sender email.
     *
     * @return string.
     */
    public function getSenderEmail()
    {
        return $this->senderEmail;
    }

    /**
     * Get sender name.
     *
     * @return string.
     */
    public function getSenderName()
    {
        return $this->senderName;
    }
}
