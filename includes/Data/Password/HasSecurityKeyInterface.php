<?php

/**
 * This file contains HasSecurityKeyInterface interface.
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
 * HasSecurityKeyInterface is an interface, it declares access to security key.
 */
interface HasSecurityKeyInterface
{
    /**
     * Get security key.
     *
     * @return string
     */
    public function getSecurity();

    /**
     * Set security key.
     *
     * @param string $security Security key.
     *
     * @return string
     */
    public function setSecurity($security);

    /**
     * Check security key.
     *
     * @param $security Security key.
     *
     * @return boolean Passed or not security key check.
     */
    public function checkSecurity($security);
}
