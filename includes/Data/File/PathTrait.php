<?php

/**
 * This file contains PathTrait trait.
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
 * PathTrait is a trait, it contains basic methods to manipulate path data.
 *
 * Implements everything from {@see \ThoPHPAuthorization\Data\Path\HasPathInterface}.
 */
trait PathTrait
{
    /**
     * Source.
     *
     * @var string
     */
    protected $path;

    /**
     * Set path to the file.
     *
     * @param string $path Path.
     *
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
