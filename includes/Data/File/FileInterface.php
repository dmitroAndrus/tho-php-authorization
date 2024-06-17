<?php

/**
 * This file contains FileInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\File;

use ThoPHPAuthorization\Data\File\HasSRCInterface;

/**
 * FileInterface is an interface, it declares a possibility to access to the file data.
 */
interface FileInterface extends HasSRCInterface
{
    /**
     * Get file content.
     *
     * @return string
     */
    public function getContent();

    /**
     * Check if file exists.
     *
     * @return boolean
     */
    public function exists();
}
