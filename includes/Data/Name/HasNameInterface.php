<?php

/**
 * This file contains HasNameInterface interface.
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
 * HasNameInterface is an interface, it declares a possibility to access to the name data.
 */
interface HasNameInterface
{
    /**
     * Set name.
     *
     * @param string $name Name.
     *
     * @return self
     */
    public function setName($name);

    /**
     * Get name.
     *
     * @return string
     */
    public function getName();
}
