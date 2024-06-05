<?php

/**
 * This file contains ReceiverTrait trait.
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
 * ReceiverTrait is a trait, it contains basic methods to manipulate receiver email data.
 *
 * Implements everything from ThoPHPAuthorization\Data\Email\HasReceiverInterface.
 */
trait ReceiverTrait
{
    /**
     * Receiver email.
     *
     * @var string
     */
    protected $receiverName;

    /**
     * Receiver email.
     *
     * @var string
     */
    protected $receiverEmail;

    /**
     * Set receiver email.
     *
     * @param string $email - Receiver email.
     * @param string $name - Receiver name.
     *
     * @return self.
     */
    public function setReceiver($email, $name = null)
    {
        $this->receiverEmail = empty($email)
            ? null
            : $email;
        $this->receiverName = empty($name)
            ? null
            : $name;
        return $this;
    }

    /**
     * Has receiver.
     *
     * @return boolean.
     */
    public function hasReceiver()
    {
        return !is_null($this->receiverEmail);
    }

    /**
     * Get receiver.
     *
     * [
     *  'name' => 'Name',
     *  'email' => 'email@mail.com'
     * ]
     *
     * @return array.
     */
    public function getReceiver()
    {
        if ($this->hasReceiver()) {
            $data = [
                'email' => $this->getReceiverEmail(),
            ];
            $name = $this->getReceiverName();
            if (!is_null($name)) {
                $data['name'] = $name;
            }
            return $data;
        }
        return null;
    }

    /**
     * Get receiver email.
     *
     * @return string.
     */
    public function getReceiverEmail()
    {
        return $this->receiverEmail;
    }

    /**
     * Get receiver name.
     *
     * @return string.
     */
    public function getReceiverName()
    {
        return $this->receiverName;
    }
}
