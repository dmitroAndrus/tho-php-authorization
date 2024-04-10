<?php

/**
 * This file contains HasIdInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\ID;

/**
 * HasIdInterface is an interface, it declares that it has ID.
 */
interface HasIDInterface
{
    /**
     * Set id.
     *
     * @param string $id - ID.
     *
     * @return self.
     */
    public function setID($id);

    /**
     * Get id.
     *
     * @return string.
     */
    public function getID();
}
