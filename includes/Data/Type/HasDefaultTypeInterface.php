<?php

/**
 * This file contains HasDefaultTypeInterface interface.
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
 * HasDefaultTypeInterface is an interface to maintain and manipulate object default type data.
 */
interface HasDefaultTypeInterface
{
    /**
     * Set default type.
     *
     * @param mixed $type Default type default type.
     *
     * @return self
     */
    public function setDefaultType($type);

    /**
     * Get default type.
     *
     * @return mixed
     */
    public function getDefaultType();
}
