<?php

/**
 * This file contains PhoneInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Phone;

use ThoPHPAuthorization\Data\Phone\HasPhoneInterface;
use ThoPHPAuthorization\Data\Type\HasTypeInterface;

/**
 * PhoneInterface is an interface to maintain and manipulate phone data.
 *
 * Should provide access to phone number and phone type data.
 *
 * Possible phone types: mobile, fax, work phone, etc.
 */
interface PhoneInterface extends HasPhoneInterface, HasTypeInterface
{
}
