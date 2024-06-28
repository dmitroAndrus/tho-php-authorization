<?php

/**
 * This file contains BirthdayTrait trait.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\DateTime;

use ThoPHPAuthorization\Service\DateTimeService;

/**
 * BirthdayTrait is a trait, it contains basic methods to manipulate birthday data.
 *
 * Implements everything from {@see \ThoPHPAuthorization\Data\DateTime\HasBirthdayInterface}.
 */
trait BirthdayTrait
{
    /**
     * Birthday date.
     *
     * @var DateTimeInterface
     * @see https://www.php.net/manual/en/class.datetimeinterface.php
     */
    protected $birthday;

    /**
     * Set birthday.
     *
     * Please check {@see https://www.php.net/manual/en/datetime.format.php} for the format settings.
     *
     * @param string|DateTimeInterface $date Birthday date.
     * @param string $format Birthday date format.
     *
     * @return self
     */
    public function setBirthday($date, $format = null)
    {
        if (empty($date)) {
            // Reset birthday.
            $this->birthday = null;
        } else {
            // Parse birthday.
            $birthday = DateTimeService::create($date, $format);
            if ($birthday) {
                $this->birthday = $birthday;
            }
        }
        return $this;
    }

    /**
     * Get birthday.
     *
     * * Returns {@link https://www.php.net/manual/en/class.datetimeinterface.php DateTimeInterface}
     * when format is not provided.
     * * Returns formated birthday string when $format is provided.
     *
     * Please check {@see https://www.php.net/manual/en/datetime.format.php} for the format settings.
     *
     * @param string $format Birthday format, when not set returns
     *                       {@link https://www.php.net/manual/en/class.datetime.php DateTime} object.
     *
     * @return DateTimeInterface|string
     */
    public function getBirthday($format = null)
    {
        if ($this->birthday) {
            if (is_string($format)) {
                return DateTimeService::format($this->birthday, $format);
            }
            return $this->birthday;
        }
        return null;
    }
}
