<?php

/**
 * This file contains HasSRCInterface interface.
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
 * HasSRCInterface is an interface, it declares a possibility to access to the src (source) data.
 */
interface HasSRCInterface
{
    /**
     * Set source.
     *
     * @param string $source - Source.
     *
     * @return self.
     */
    public function setSRC($source);

    /**
     * Get source.
     *
     * @return string.
     */
    public function getSRC();
}
