<?php

/**
 * This file contains NameTrait trait.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Name;

/**
 * NameTrait is a trait, it contains basic methods to manipulate name data.
 *
 * Implements everything from {@see \ThoPHPAuthorization\Data\Name\HasNameInterface}.
 */
trait NameTrait
{
    /**
     * Name.
     *
     * @var string
     */
    protected $name;

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name Name.
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
