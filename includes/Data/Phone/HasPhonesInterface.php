<?php

/**
 * This file contains HasPhonesInterface interface.
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
 * HasPhonesInterface is an interface, it declares a possibility to access multiple phones data.
 */
interface HasPhonesInterface
{
    /**
     * Set phones.
     *
     * @param PhoneInterface[]|mixed $phones Phones list.
     *
     * @return self
     */
    public function setPhones($phones);

    /**
     * Add phones.
     *
     * @param PhoneInterface[]|mixed $phones Phones list.
     *
     * @return self
     */
    public function addPhones($phones);

    /**
     * Add phone.
     *
     * @param mixed $phone Phone.
     *
     * @return self
     */
    public function addPhone($phone);

    /**
     * Get all phones.
     *
     * @return PhoneInterface[]|null List of all available phones or null when none found.
     */
    public function getPhones();

    /**
     * Get all phones with specified phone type.
     *
     * Possible types: mobile, fax, work phone, etc.
     *
     * @param string $type Phone type.
     *
     * @return PhoneInterface[]|null List of all phones with specified phone type or null when none found.
     */
    public function getPhonesByType($type);

    /**
     * Get first phone with specified phone type.
     *
     * Possible types: mobile, fax, work phone, etc.
     *
     * @param string $type Phone type.
     *
     * @return PhoneInterface|null Phone object or null when none found.
     */
    public function getFirstPhoneByType($type);

    /**
     * Has atleast one phone with specified phone type.
     *
     * Possible types: mobile, fax, work phone, etc.
     *
     * @param string $type Phone type.
     *
     * @return boolean
     */
    public function hasPhoneType($type);
}
