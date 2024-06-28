<?php

/**
 * This file contains ValidUntilTrait trait.
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
 * ValidUntilTrait is a trait, it contains basic methods to manipulate valid until date and time data.
 *
 * Implements everything from {@see \ThoPHPAuthorization\Data\DateTime\HasValidUntilInterface}.
 */
trait ValidUntilTrait
{
    /**
     * Valid until date and time.
     *
     * @var DateTimeInterface
     * @see https://www.php.net/manual/en/class.datetimeinterface.php
     */
    protected $validUntil;

    /**
     * Set valid until date and time.
     *
     * Please check {@see https://www.php.net/manual/en/datetime.format.php} for the format settings.
     *
     * @param string|DateTimeInterface $date Valid until date and time.
     * @param string $format Valid until date and time format.
     *
     * @return self
     */
    public function setValidUntil($date, $format = null)
    {
        if (empty($date)) {
            // Reset valid until date and time.
            $this->validUntil = null;
        } else {
            // Parse valid until date and time.
            $valid_until = DateTimeService::create($date, $format);
            if ($valid_until) {
                $this->validUntil = $valid_until;
            }
        }
        return $this;
    }

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
    public function getValidUntil($format = null)
    {
        if ($this->validUntil) {
            if (is_string($format)) {
                return DateTimeService::format($this->validUntil, $format);
            }
            return $this->validUntil;
        }
        return null;
    }
}
