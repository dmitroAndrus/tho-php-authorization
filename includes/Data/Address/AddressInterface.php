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
use ThoPHPAuthorization\Data\Type\HasTypeInterface;

/**
 * AddressInterface is an interface to maintain and manipulate address data.
 *
 * Should provide access to country, state, city, address, zip code and address type data.
 * Possible address types: home, delivery, billing, work, etc.
 */
interface AddressInterface extends HasAddressInterface, HasTypeInterface
{
}
