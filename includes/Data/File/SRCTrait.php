<?php

/**
 * This file contains SRCTrait trait.
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
 * SRCTrait is a trait, it contains basic methods to manipulate SRC (source) data.
 *
 * Implements everything from {@see \ThoPHPAuthorization\Data\SRC\HasSRCInterface}.
 */
trait SRCTrait
{
    /**
     * Source.
     *
     * @var string
     */
    protected $src;

    /**
     * Set source.
     *
     * @param string $src Source.
     *
     * @return self
     */
    public function setSRC($src)
    {
        $this->src = $src;
        return $this;
    }

    /**
     * Get src.
     *
     * @return string
     */
    public function getSRC()
    {
        return $this->src;
    }
}
