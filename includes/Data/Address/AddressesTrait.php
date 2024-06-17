<?php

/**
 * This file contains AddressesTrait trait.
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
use ThoPHPAuthorization\Data\Address\HasAddressesInterface;

/**
 * AddressesTrait is a trait, it contains basic methods to manipulate multiple addresses data.
 *
 * Implements everything from {@see \ThoPHPAuthorization\Data\Address\HasAddressesInterface}.
 */
trait AddressesTrait
{
    /**
     * Addresses.
     *
     * @var AddressInterface[]
     */
    protected $addresses = [];

    /**
     * Add address.
     *
     * @param AddressInterface|mixed $address Address.
     *
     * @return self
     */
    public function addAddress($address)
    {
        if ($address instanceof AddressInterface) {
            $this->addresses[] = $address;
        }
        return $this;
    }

    /**
     * Get all available addresses.
     *
     * @return AddressInterface[]|null List of all available addresses or null, when none found.
     */
    public function getAddresses()
    {
        return empty($this->addresses) ? null : $this->addresses;
    }

    /**
     * Get all addresses with specified address type.
     *
     * Possible types: home, delivery, billing, work, etc.
     *
     * @param string $type Address type.
     *
     * @return AddressInterface[]|null List of all addresses with specified address type or null when none found.
     */
    public function getAddressesByType($type)
    {
        $addresses = [];
        foreach ($this->addresses as $address) {
            if ($address->isOfType($type)) {
                $addresses[] = $address;
            }
        }
        return empty($addresses) ? null : $addresses;
    }

    /**
     * Get first address with specified address type.
     *
     * Possible types: home, delivery, billing, work, etc.
     *
     * @param string $type Address type.
     *
     * @return AddressInterface|null Address object or null when none found.
     */
    public function getFirstAddressByType($type)
    {
        foreach ($this->addresses as $address) {
            if ($address->isOfType($type)) {
                return $address;
            }
        }
        return null;
    }

    /**
     * Has atleast one address with specified address type.
     *
     * Possible types: home, delivery, billing, work, etc.
     *
     * @param string $type Address type.
     *
     * @return boolean Returns true - when address of such type exists, false - otherwise.
     */
    public function hasAddressType($type)
    {
        foreach ($this->addresses as $address) {
            if ($address->isOfType($type)) {
                return true;
            }
        }
        return false;
    }
}
