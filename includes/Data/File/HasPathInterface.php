<?php

/**
 * This file contains HasPathInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\File;

/**
 * HasPathInterface is an interface, it declares a possibility to access to the path data.
 */
interface HasPathInterface
{
    /**
     * Set file src.
     *
     * @param string $source File src.
     *
     * @return self
     */
    public function setPath($source);

    /**
     * Get file src.
     *
     * @return string
     */
    public function getPath();
}
