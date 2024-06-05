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
     * Get a string representation of the object.
     *
     * @return string.
     */
    public function __toString()
    {
        return $this->getFullAddress();
    }
}
