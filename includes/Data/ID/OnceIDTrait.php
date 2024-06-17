<?php

/**
 * This file contains OnceIDTrait trait.
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
 * IDTrait is a trait, it contains basic methods to set/get ID, but setting is allowed only once.
 */
trait OnceIDTrait
{
    /**
     * ID.
     *
     * @var string
     */
    protected $id = null;

    /**
     * Get ID.
     *
     * @return string
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * Set ID.
     *
     * @param string $id - ID.
     *
     * @return self
     */
    public function setID($id)
    {
        if (is_null($this->id) && !is_null($id)) {
            $this->id = $id;
        }
        return $this;
    }
}
