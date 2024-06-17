<?php

/**
 * This file contains HasAddressInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Address;

/**
 * HasAddressInterface is an interface, it declares a possibility to access to the address data.
 */
interface HasAddressInterface
{
    /**
     * Set country.
     *
     * @param string $country Country.
     *
     * @return self
     */
    public function setCountry($country);

    /**
     * Get country.
     *
     * @return string
     */
    public function getCountry();

    /**
     * Set state.
     *
     * @param string $state State.
     *
     * @return self
     */
    public function setState($state);

    /**
     * Get state.
     *
     * @return string
     */
    public function getState();

    /**
     * Set city.
     *
     * @param string $city City.
     *
     * @return self
     */
    public function setCity($city);

    /**
     * Get city.
     *
     * @return string
     */
    public function getCity();

    /**
     * Set address.
     *
     * @param string $address Address.
     *
     * @return self
     */
    public function setAddress($address);

    /**
     * Get address.
     *
     * @return string
     */
    public function getAddress();

    /**
     * Set zip code.
     *
     * @param string $zip ZIP code.
     *
     * @return self
     */
    public function setZIP($zip);

    /**
     * Get zip code.
     *
     * @return string
     */
    public function getZIP();

    /**
     * Get formated address.
     *
     * @param string $format Address format.
     *
     * @return string
     */
    public function getFormatedAddress($format);

    /**
     * Get full address.
     *
     * @return string
     */
    public function getFullAddress();
}
