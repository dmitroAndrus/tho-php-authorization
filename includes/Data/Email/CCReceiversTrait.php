<?php

/**
 * This file contains CCReceiversTrait trait.
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
 * CCReceiversTrait is a trait, it contains basic methods to manipulate CC receivers emails data.
 *
 * Implements everything from {@see \ThoPHPAuthorization\Data\Email\HasCCReceiversInterface}.
 */
trait CCReceiversTrait
{
    /**
     * CCReceivers.
     *
     * @var array
     */
    protected $ccReceivers = [];

    /**
     * Add CC receiver email.
     *
     * @param string $email Receiver email.
     * @param string $name Receiver name.
     *
     * @return self
     */
    public function addCCReceiver($email, $name = null)
    {
        if (!empty($email)) {
            $this->ccReceivers[$email] = empty($name)
                ? null
                : $name;
        }
        return $this;
    }

    /**
     * Has CC receivers.
     *
     * @return boolean
     */
    public function hasCCReceivers()
    {
        return count($this->ccReceivers) > 0;
    }

    /**
     * Get CC receivers.
     *
     * @return array
     */
    public function getCCReceivers()
    {
        $ccReceivers = [];
        foreach ($this->ccReceivers as $email => $name) {
            $receiver = [
                'email' => $email,
            ];
            if (!is_null($name)) {
                $receiver['name'] = $name;
            }
            $ccReceivers[] = $receiver;
        }
        return $ccReceivers;
    }

    /**
     * Get CC receivers emails.
     *
     * @return array
     */
    public function getCCReceiversEmails()
    {
        return array_keys($this->ccReceivers);
    }

    /**
     * Get CC receivers names.
     *
     * @return array
     */
    public function getCCReceiversNames()
    {
        $names = [];
        foreach ($this->ccReceivers as $name) {
            if (!is_null($name)) {
                $names[] = $name;
            }
        }
        return $names;
    }
}
