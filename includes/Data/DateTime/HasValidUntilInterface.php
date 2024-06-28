<?php

/**
 * This file contains HasValidUntilInterface interface.
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
 * HasValidUntilInterface is an interface, it declares a possibility to access to the valid until date and time.
 */
interface HasValidUntilInterface
{
    /**
     * Set valid until date and time.
     *
     * Please check https://www.php.net/manual/en/datetime.format.php for the format settings.
     *
     * @param string|DateTime $datetime - Valid until date and time.
     * @param string $format - Valid until date and time format.
     *
     * @return self
     */
    public function setValidUntil($datetime);

    /**
     * Get valid until date and time.
     *
     * * Returns {@link https://www.php.net/manual/en/class.datetimeinterface.php DateTimeInterface}
     * when format is not provided.
     * * Returns formated valid until date and time string when $format is provided.
     *
     * Please check {@see https://www.php.net/manual/en/datetime.format.php} for the format settings.
     *
     * @param string $format Valid until date and time format, when not set returns
     *                       {@link https://www.php.net/manual/en/class.datetime.php DateTime} object.
     *
     * @return DateTimeInterface|string
     */
    public function getValidUntil($format = null);
}
