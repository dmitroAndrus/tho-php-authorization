<?php

/**
 * This file contains SecurityKeyTrait trait.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Password;

/**
 * SecurityKeyTrait is a trait that provides access to security key.
 *
 * Implements everything from {@see \ThoPHPAuthorization\Data\Password\HasSecurityKeyInterface}.
 */
trait SecurityKeyTrait
{
    /**
     * Security key.
     *
     * @var string
     */
    protected $security;

    /**
     * Get security key.
     *
     * @return string
     */
    public function getSecurity()
    {
        return $this->security;
    }

    /**
     * Set security key.
     *
     * @param string $security Security key.
     *
     * @return string
     */
    public function setSecurity($security)
    {
        $this->security = $security;
        return $this;
    }

    /**
     * Check security key.
     *
     * @param $security Security key.
     *
     * @return boolean Passed or not security key check.
     */
    public function checkSecurity($security)
    {
        return $this->getSecurity() === $security;
    }
}
