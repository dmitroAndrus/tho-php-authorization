<?php

/**
 * This file contains Phone class.
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
use ThoPHPAuthorization\Data\Phone\PhoneTrait;
use ThoPHPAuthorization\Data\Type\TypeTrait;

/**
 * Phone is a class to manipulate phone data.
 *
 * Provides access to phone number and phone type data.
 *
 * Possible phone types: mobile, fax, work phone, etc.
 */
class Phone implements PhoneInterface
{
    use PhoneTrait;
    use TypeTrait;

    /**
     * Get a string representation of the object.
     *
     * @return string
     */
    public function __toString()
    {
        $phone = $this->getPhone();
        return $phone ? (string) $phone : '';
    }
}
