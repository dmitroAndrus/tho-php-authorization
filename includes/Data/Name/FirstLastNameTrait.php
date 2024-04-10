<?php

/**
 * This file contains FirstLastNameTrait trait.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Name;

use ThoPHPAuthorization\Service\TemplatingService;

/**
 * FirstLastNameTrait is a trait, it contains basic methods to manipulate first and last name data.
 *
 * Implements everything from ThoPHPAuthorization\Data\Name\HasFirstLastNameInterface.
 */
trait FirstLastNameTrait
{
    /**
     * First name.
     *
     * @var string
     */
    protected $firstName;

    /**
     * Last name.
     *
     * @var string
     */
    protected $lastName;

    /**
     * Full name format.
     *
     * Format variables goes from the data received from 'getFullNameData' method.
     * Format example: {firstName} {lastName}.
     *
     * @var string
     */
    protected $fullNameFormat = '{firstName} {lastName}';

    /**
     * Set first name.
     *
     * @param string $firstName - First name.
     *
     * @return self.
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * Get first name.
     *
     * @return string.
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set last name.
     *
     * @param string $lastName - Last name.
     *
     * @return self.
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * Get last name.
     *
     * @return string.
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set full name format.
     *
     * @param string $format - Address.
     *
     * @return self.
     */
    public function setFullNameFormat($format)
    {
        $this->fullNameFormat = $format;
        return $this;
    }

    /**
     * Get full name format.
     *
     * @return string.
     */
    public function getFullNameFormat()
    {
        return $this->fullNameFormat;
    }

    /**
     * Get all name data.
     *
     * @return string.
     */
    public function getNameData()
    {
        return [
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
        ];
    }

    /**
     * Get formated name data.
     *
     * @param string $format - Name format.
     *
     * @return string.
     */
    public function getFormatedName($format)
    {
        // Check format.
        if (!($format && is_string($format))) {
            return '';
        }

        $data = $this->getNameData();

        // Replace format string with actual data.
        return TemplatingService::parseSimpleTemplate($format, $data);
    }

    /**
     * Get full name.
     *
     * @return string.
     */
    public function getFullName()
    {
        return $this->getFormatedName($this->getFullNameFormat());
    }
}
