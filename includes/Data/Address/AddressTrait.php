<?php

/**
 * This file contains AddressTrait trait.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Address;

use ThoPHPAuthorization\Service\TemplatingService;

/**
 * AddressTrait is a trait, it contains basic methods to manipulate address data.
 *
 * Implements everything from ThoPHPAuthorization\Data\Address\HasAddressInterface.
 */
trait AddressTrait
{
    /**
     * Country.
     *
     * @var string
     */
    protected $country;

    /**
     * State.
     *
     * @var string
     */
    protected $state;

    /**
     * City.
     *
     * @var string
     */
    protected $city;

    /**
     * Address.
     *
     * @var string
     */
    protected $address;

    /**
     * ZIP code.
     *
     * @var string
     */
    protected $zip;

    /**
     * Full address format.
     *
     * Format variables goes from the data received from 'getAddressData' method.
     * Format example: {address}, {city}, {state} {zip}, {country}.
     *
     * @var string
     */
    protected $addressFormat = '{address}, {city}, {state} {zip}, {country}';

    /**
     * Set country.
     *
     * @param string $country - Country.
     *
     * @return self.
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Get country.
     *
     * @return string.
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set state.
     *
     * @param string $state - State.
     *
     * @return self.
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * Get state.
     *
     * @return string.
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set city.
     *
     * @param string $city - City.
     *
     * @return self.
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Get city.
     *
     * @return string.
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set address.
     *
     * @param string $address - Address.
     *
     * @return self.
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Get address.
     *
     * @return string.
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set zip.
     *
     * @param string $zip - ZIP.
     *
     * @return self.
     */
    public function setZIP($zip)
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * Get zip.
     *
     * @return string.
     */
    public function getZIP()
    {
        return $this->zip;
    }

    /**
     * Set full address format.
     *
     * @param string $format - Address.
     *
     * @return self.
     */
    public function setAddressFormat($format)
    {
        $this->addressFormat = $format;
        return $this;
    }

    /**
     * Get full address format.
     *
     * @return string.
     */
    public function getAddressFormat()
    {
        return $this->addressFormat;
    }

    /**
     * Get all address data.
     *
     * @return string.
     */
    public function getAddressData()
    {
        return [
            'country' => $this->getCountry(),
            'state' => $this->getState(),
            'city' => $this->getCity(),
            'address' => $this->getAddress(),
            'zip' => $this->getZip(),
        ];
    }

    /**
     * Get formated address.
     *
     * Format variables goes from the data received from 'getAddressData' method.
     * Format example: {address}, {city}, {state} {zip}, {country}.
     *
     * @param string $format - Address format.
     *
     * @return string.
     */
    public function getFormatedAddress($format)
    {
        // Check format.
        if (!($format && is_string($format))) {
            return '';
        }

        $data = $this->getAddressData();

        // Replace format string with actual data.
        return TemplatingService::parseSimpleTemplate($format, $data);
    }

    /**
     * Get full address.
     *
     * @return string.
     */
    public function getFullAddress()
    {
        return $this->getFormatedAddress($this->getAddressFormat());
    }
}
