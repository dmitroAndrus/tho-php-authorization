<?php

/**
 * This file contains ReceiversTrait trait.
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
 * ReceiversTrait is a trait, it contains basic methods to manipulate receivers emails data.
 *
 * Implements everything from ThoPHPAuthorization\Data\Email\HasReceiversInterface.
 */
trait ReceiversTrait
{
    /**
     * Receivers.
     *
     * @var array
     */
    protected $receivers = [];

    /**
     * Add receiver email.
     *
     * @param string $email - Receiver email.
     * @param string $name - Receiver name.
     *
     * @return self.
     */
    public function addReceiver($email, $name = null)
    {
        if (!empty($email)) {
            $this->receivers[$email] = empty($name)
                ? null
                : $name;
        }
        return $this;
    }

    /**
     * Has receivers.
     *
     * @return boolean.
     */
    public function hasReceivers()
    {
        return count($this->receivers) > 0;
    }

    /**
     * Get receivers.
     *
     * @return array.
     */
    public function getReceivers()
    {
        $receivers = [];
        foreach ($this->receivers as $email => $name) {
            $receiver = [
                'email' => $email,
            ];
            if (!is_null($name)) {
                $receiver['name'] = $name;
            }
            $receivers[] = $receiver;
        }
        return $receivers;
    }

    /**
     * Get receivers emails.
     *
     * @return array.
     */
    public function getReceiversEmails()
    {
        return array_keys($this->receivers);
    }

    /**
     * Get receivers names.
     *
     * @return array.
     */
    public function getReceiversNames()
    {
        $names = [];
        foreach ($this->receivers as $name) {
            if (!is_null($name)) {
                $names[] = $name;
            }
        }
        return $names;
    }
}
