<?php

/**
 * This file contains HasTypeInterface interface.
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
 * HasTypeInterface is an interface to maintain and manipulate object type data.
 */
interface HasTypeInterface
{
    /**
     * Set type.
     *
     * @param mixed $type Type.
     *
     * @return self
     */
    public function setType($type);

    /**
     * Get type.
     *
     * @return mixed
     */
    public function getType();

    /**
     * Check type.
     *
     * @param mixed $type Type.
     *
     * @return boolean
     */
    public function isOfType($type);
}
