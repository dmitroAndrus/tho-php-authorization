<?php

/**
 * This file contains LocalFileInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\File;

use ThoPHPAuthorization\Data\File\HasPathInterface;

/**
 * LocalFileInterface is an interface, it declares a possibility to access to the local file data.
 */
interface LocalFileInterface extends FileInterface, HasPathInterface
{
    /**
     * Get file base name.
     *
     * @return string|null File base name or null, when no file specified.
     */
    public function getBaseName();

    /**
     * Set path to the file.
     *
     * @param string $path Path.
     *
     * @return self
     */
    public function setPath($path);

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath();
}
