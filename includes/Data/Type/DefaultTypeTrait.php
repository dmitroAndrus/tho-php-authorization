<?php

/**
 * This file contains DefaultTypeTrait trait.
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
 * DefaultTypeTrait is a trait, it contains basic methods to object default type data.
 *
 * Implements everything from ThoPHPAuthorization\Data\DefaultType\HasDefaultTypeInterface.
 */
trait DefaultTypeTrait
{
    /**
     * DefaultType.
     *
     * @var string
     */
    protected $defaultType;

    /**
     * Set default type.
     *
     * @param mixed $type - DefaultType default type.
     *
     * @return self.
     */
    public function setDefaultType($type)
    {
        $this->defaultType = $type;
        return $this;
    }

    /**
     * Get default type.
     *
     * @return mixed.
     */
    public function getDefaultType()
    {
        return $this->defaultType;
    }
}
