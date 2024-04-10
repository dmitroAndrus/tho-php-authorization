<?php

/**
 * This file contains StrictNameTrait trait.
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
 * StrictNameTrait is a trait to maintain readonly name.
 */
trait StrictNameTrait
{
    /**
     * Name.
     *
     * @var string
     */
    protected $name;

    /**
     * Get name.
     *
     * @return string.
     */
    public function getName()
    {
        return $this->name;
    }
}
