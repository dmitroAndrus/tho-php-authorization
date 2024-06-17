<?php

/**
 * This file contains FromTrait trait.
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
 * FromTrait is a trait, it contains basic methods to manipulate from email data.
 *
 * Implements everything from {@see \ThoPHPAuthorization\Data\Email\HasFromInterface}.
 */
trait FromTrait
{
    /**
     * From email.
     *
     * @var string
     */
    protected $fromName;

    /**
     * From email.
     *
     * @var string
     */
    protected $fromEmail;

    /**
     * Set from email.
     *
     * @param string $name From name.
     * @param string $email From email.
     *
     * @return self
     */
    public function setFrom($email, $name = null)
    {
        $this->fromEmail = empty($email)
            ? null
            : $email;
        $this->fromName = empty($name)
            ? null
            : $name;
        return $this;
    }

    /**
     * Has from.
     *
     * @return boolean
     */
    public function hasFrom()
    {
        return !is_null($this->fromEmail);
    }

    /**
     * Get from.
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
    public function getFrom()
    {
        if ($this->hasFrom()) {
            $data = [
                'email' => $this->getFromEmail(),
            ];
            $name = $this->getFromName();
            if (!is_null($name)) {
                $data['name'] = $name;
            }
            return $data;
        }
        return null;
    }

    /**
     * Get from email.
     *
     * @return string
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * Get from name.
     *
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }
}
