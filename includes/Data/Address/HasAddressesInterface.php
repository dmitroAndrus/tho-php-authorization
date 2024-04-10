<?php

/**
 * This file contains HasAddressesInterface interface.
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

/**
 * HasAddressesInterface is an interface, it declares a possibility to access multiple addresses data.
 */
interface HasAddressesInterface
{
    /**
     * Add address.
     *
     * @param mixed $address - Address.
     *
     * @return self
     */
    public function addAddress($address);

    /**
     * Get all addresses.
     *
     * @return AddressInterface[]|null - List of all available addresses or null when none found.
     */
    public function getAddresses();

    /**
     * Get all addresses with specified address type.
     *
     * Possible types: home, delivery, billing, work, etc.
     *
     * @param string $type - Address type.
     *
     * @return AddressInterface[]|null - List of all addresses with specified address type or null when none found.
     */
    public function getAddressesByType($type);

    /**
     * Get first address with specified address type.
     *
     * Possible types: home, delivery, billing, work, etc.
     *
     * @param string $type - Address type.
     *
     * @return AddressInterface|null - Address object or null when none found.
     */
    public function getFirstAddressByType($type);

    /**
     * Has atleast one address with specified address type.
     *
     * Possible types: home, delivery, billing, work, etc.
     *
     * @param string $type - Address type.
     *
     * @return boolean
     */
    public function hasAddressType($type);
}
