<?php

/**
 * This file contains BCCReceiversTrait trait.
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
 * BCCReceiversTrait is a trait, it contains basic methods to manipulate BCC receivers emails data.
 *
 * Implements everything from {@see \ThoPHPAuthorization\Data\Email\HasBCCReceiversInterface}.
 */
trait BCCReceiversTrait
{
    /**
     * BCCReceivers.
     *
     * @var array
     */
    protected $bccReceivers = [];

    /**
     * Add BCC receiver email.
     *
     * @param string $email Receiver email.
     * @param string $name Receiver name.
     *
     * @return self
     */
    public function addBCCReceiver($email, $name = null)
    {
        if (!empty($email)) {
            $this->bccReceivers[$email] = empty($name)
                ? null
                : $name;
        }
        return $this;
    }

    /**
     * Has BCC receivers.
     *
     * @return boolean
     */
    public function hasBCCReceivers()
    {
        return count($this->bccReceivers) > 0;
    }

    /**
     * Get BCC receivers.
     *
     * @return array
     */
    public function getBCCReceivers()
    {
        $bccReceivers = [];
        foreach ($this->bccReceivers as $email => $name) {
            $receiver = [
                'email' => $email,
            ];
            if (!is_null($name)) {
                $receiver['name'] = $name;
            }
            $bccReceivers[] = $receiver;
        }
        return $bccReceivers;
    }

    /**
     * Get BCC receivers emails.
     *
     * @return array
     */
    public function getBCCReceiversEmails()
    {
        return array_keys($this->bccReceivers);
    }

    /**
     * Get BCC receivers names.
     *
     * @return array
     */
    public function getBCCReceiversNames()
    {
        $names = [];
        foreach ($this->bccReceivers as $name) {
            if (!is_null($name)) {
                $names[] = $name;
            }
        }
        return $names;
    }
}
