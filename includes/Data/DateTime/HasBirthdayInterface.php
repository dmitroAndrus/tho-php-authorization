<?php

/**
 * This file contains HasBirthdayInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\DateTime;

/**
 * HasBirthdayInterface is an interface, it declares a possibility to access to the birthday data.
 */
interface HasBirthdayInterface
{
    /**
     * Set birthday.
     *
     * Please check https://www.php.net/manual/en/datetime.format.php for format settings.
     *
     * @param string|DateTime $date - Birthday date.
     * @param string $format - Birthday date format.
     *
     * @return self.
     */
    public function setBirthday($date);

    /**
     * Get birthday.
     *
     * Please check https://www.php.net/manual/en/datetime.format.php for format settings.
     *
     * @param string $format - Birthday format, when not set returns DateTime object.
     *
     * @return string.
     */
    public function getBirthday($format = null);
}
