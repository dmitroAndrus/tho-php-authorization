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

/**
 * Phone is a class to manipulate phone data.
 */
class Phone implements PhoneInterface
{
    use PhoneTrait;

    /**
     * Phone type.
     *
     * Possible types: mobile, fax, work phone, etc.
     *
     * @var string
     */
    protected $phoneType;

    /**
     * {@inheritdoc}
     */
    public function setPhoneType($type)
    {
        $this->phoneType = $type;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhoneType()
    {
        return $this->phoneType;
    }

    /**
     * {@inheritdoc}
     */
    public function isPhoneType($type)
    {
        return $this->getPhoneType() === $type;
    }
}
