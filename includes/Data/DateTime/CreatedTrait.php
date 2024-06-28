<?php

/**
 * This file contains CreatedTrait trait.
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
 * CreatedTrait is a trait, it contains basic methods to manipulate created date and time data.
 *
 * Implements everything from {@see \ThoPHPAuthorization\Data\DateTime\HasCreatedInterface}.
 */
trait CreatedTrait
{
    /**
     * Created date and time.
     *
     * @var DateTimeInterface
     * @see https://www.php.net/manual/en/class.datetimeinterface.php
     */
    protected $created;

    /**
     * Set created date and time.
     *
     * Please check {@see https://www.php.net/manual/en/datetime.format.php} for the format settings.
     *
     * @param string|DateTimeInterface $date Created date and time.
     * @param string $format Created date and time format.
     *
     * @return self
     */
    public function setCreated($date, $format = null)
    {
        if (empty($date)) {
            // Reset created date and time.
            $this->created = null;
        } else {
            // Parse created date and time.
            $created = DateTimeService::create($date, $format);
            if ($created) {
                $this->created = $created;
            }
        }
        return $this;
    }

    /**
     * Get created date and time.
     *
     * * Returns {@link https://www.php.net/manual/en/class.datetimeinterface.php DateTimeInterface}
     * when format is not provided.
     * * Returns formated created date and time string when $format is provided.
     *
     * Please check {@see https://www.php.net/manual/en/datetime.format.php} for the format settings.
     *
     * @param string $format Created date and time format, when not set returns
     *                       {@link https://www.php.net/manual/en/class.datetime.php DateTime} object.
     *
     * @return DateTimeInterface|string
     */
    public function getCreated($format = null)
    {
        if ($this->created) {
            if (is_string($format)) {
                return DateTimeService::format($this->created, $format);
            }
            return $this->created;
        }
        return null;
    }
}
