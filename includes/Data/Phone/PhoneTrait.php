<?php

/**
 * This file contains PhoneTrait trait.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Phone;

use ThoPHPAuthorization\Service\TemplatingService;

/**
 * PhoneTrait is a trait, it contains basic methods to manipulate phone data.
 *
 * Implements everything from {@see \ThoPHPAuthorization\Data\Phone\HasPhoneInterface}.
 */
trait PhoneTrait
{
    /**
     * Phone.
     *
     * @var string
     */
    protected $phone;

    /**
     * Set phone.
     *
     * @param string $phone Phone.
     *
     * @return self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Get phone.
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }
}
