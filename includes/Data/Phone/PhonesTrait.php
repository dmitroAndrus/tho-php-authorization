<?php

/**
 * This file contains PhonesTrait trait.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Phone;

use ThoPHPAuthorization\Data\Phone\PhoneInterface;

/**
 * PhonesTrait is a trait, it contains basic methods to manipulate multiple phones data.
 *
 * Implements everything from {@see \ThoPHPAuthorization\Data\Phone\HasPhonesInterface}.
 */
trait PhonesTrait
{
    /**
     * Phones.
     *
     * @var PhoneInterface[]
     */
    protected $phones = [];

    /**
     * Set phones.
     *
     * @param PhoneInterface[]|mixed $phones Phones list.
     *
     * @return self
     */
    public function setPhones($phones)
    {
        $this->phones = [];
        return $this->addPhones($phones);
    }

    /**
     * Add phones.
     *
     * @param PhoneInterface[]|mixed $phones Phones list.
     *
     * @return self
     */
    public function addPhones($phones)
    {
        if (is_array($phones)) {
            foreach ($phones as $phone) {
                $this->addPhone($phone);
            }
        }
        return $this;
    }

    /**
     * Add phone.
     *
     * @param mixed $phone Phone.
     *
     * @return self
     */
    public function addPhone($phone)
    {
        if ($phone instanceof PhoneInterface) {
            $this->phones[] = $phone;
        }
        return $this;
    }

    /**
     * Get all phones.
     *
     * @return PhoneInterface[]|null List of all available phones or null when none found.
     */
    public function getPhones()
    {
        return empty($this->phones) ? null : $this->phones;
    }

    /**
     * Get all phones with specified phone type.
     *
     * Possible types: mobile, fax, work phone, etc.
     *
     * @param string $type Phone type.
     *
     * @return PhoneInterface[]|null List of all phones with specified phone type or null when none found.
     */
    public function getPhonesByType($type)
    {
        $phones = [];
        foreach ($this->phones as $phone) {
            if ($phone->isPhoneType($type)) {
                $phones[] = $phone;
            }
        }
        return empty($phones) ? null : $phones;
    }

    /**
     * Get first phone with specified phone type.
     *
     * Possible types: mobile, fax, work phone, etc.
     *
     * @param string $type Phone type.
     *
     * @return PhoneInterface|null Phone object or null when none found.
     */
    public function getFirstPhoneByType($type)
    {
        foreach ($this->phones as $phone) {
            if ($phone->isPhoneType($type)) {
                return $phone;
            }
        }
        return null;
    }

    /**
     * Has atleast one phone with specified phone type.
     *
     * Possible types: mobile, fax, work phone, etc.
     *
     * @param string $type Phone type.
     *
     * @return boolean
     */
    public function hasPhoneType($type)
    {
        foreach ($this->phones as $phone) {
            if ($phone->isPhoneType($type)) {
                return true;
            }
        }
        return false;
    }
}
