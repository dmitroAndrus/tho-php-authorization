<?php

/**
 * This file contains AddressInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Address;

use ThoPHPAuthorization\Data\Address\HasAddressInterface;

/**
 * AddressInterface is an interface to maintain and manipulate address data.
 */
interface AddressInterface extends HasAddressInterface
{
    /**
     * Set address type.
     *
     * Possible types: home, delivery, billing, work, etc.
     *
     * @param mixed $type - Address type.
     *
     * @return self.
     */
    public function setAddressType($type);

    /**
     * Get address type.
     *
     * @return string.
     */
    public function getAddressType();

    /**
     * Check address type.
     *
     * Possible types: home, delivery, billing, work, etc.
     *
     * @param string $type - Address type.
     *
     * @return boolean.
     */
    public function isAddressType($type);
}
