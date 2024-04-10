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

/**
 * Address is a class to manipulate address data.
 */
class Address implements AddressInterface
{
    use AddressTrait;

    /**
     * Address type.
     *
     * Possible types: home, delivery, billing, work, etc.
     *
     * @var string
     */
    protected $addressType;

    /**
     * {@inheritdoc}
     */
    public function setAddressType($type)
    {
        $this->addressType = $type;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAddressType()
    {
        return $this->addressType;
    }

    /**
     * {@inheritdoc}
     */
    public function isAddressType($type)
    {
        return $this->getAddressType() === $type;
    }
}
