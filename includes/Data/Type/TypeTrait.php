<?php

/**
 * This file contains TypeTrait trait.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Type;

/**
 * TypeTrait is a trait, it contains basic methods to object type data.
 *
 * Implements everything from ThoPHPAuthorization\Data\Type\HasTypeInterface.
 */
trait TypeTrait
{
    /**
     * Type.
     *
     * @var string
     */
    protected $type;

    /**
     * Set type.
     *
     * @param mixed $type - Type type.
     *
     * @return self.
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type.
     *
     * @return mixed.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Check type.
     *
     * @param mixed $type - Type.
     *
     * @return boolean.
     */
    public function isOfType($type)
    {
        return $this->getType() === $type;
    }
}
