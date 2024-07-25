<?php

/**
 * This file contains Address class.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Address;

use ThoPHPAuthorization\Data\Address\AddressInterface;
use ThoPHPAuthorization\Data\Address\AddressTrait;
use ThoPHPAuthorization\Data\Type\TypeTrait;

/**
 * Address is a class to manipulate address data.
 *
 * Provides access to country, state, city, address, zip code and address type data.
 * Possible address types: home, delivery, billing, work, etc.
 */
class Address implements AddressInterface
{
    use AddressTrait;
    use TypeTrait;

    /**
     * Constructor.
     *
     * @param array $data Address data.
     *
     * @return void
     */
    public function __construct(array $data = [])
    {
        // Set type.
        if (isset($data['type']) && !empty($data['type'])) {
            $this->setType($data['type']);
        }
        // Set Country.
        if (isset($data['country']) && !empty($data['country'])) {
            $this->setCountry($data['country']);
        }
        // Set State.
        if (isset($data['state']) && !empty($data['state'])) {
            $this->setState($data['state']);
        }
        // Set City.
        if (isset($data['city']) && !empty($data['city'])) {
            $this->setCity($data['city']);
        }
        // Set Address.
        if (isset($data['address']) && !empty($data['address'])) {
            $this->setAddress($data['address']);
        }
        // Set ZIP.
        if (isset($data['zip']) && !empty($data['zip'])) {
            $this->setZIP($data['zip']);
        }
    }

    /**
     * Get a string representation of the object.
     *
     * @return string String representation of the object.
     */
    public function __toString()
    {
        return $this->getFullAddress();
    }
}
