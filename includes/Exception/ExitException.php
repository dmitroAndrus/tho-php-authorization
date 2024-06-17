<?php

/**
 * This file contains ExitException exception.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Exception;

/**
 * ExitException is an exception, that should be thrown to exit to the closest try-catch block.
 */
class ExitException extends \Exception
{
    /**
     * Exceprion data.
     *
     * @var array
     */
    protected $data;

    /**
     * Create ExitException object with provided message and data.
     *
     * @param mixed $message Error message.
     * @param array|null $data Error data.
     *
     * @return ExitException
     */
    public static function create(string $message = "", $data = null)
    {
        $code = is_array($data) && isset($data['code']) ? (int) $data['code'] : 0;
        return new ExitException($message, $code, $data);
    }

    /**
     * Constructor.
     *
     * @param string $message Message.
     * @param integer $code Code.
     * @param array|null $data Data.
     *
     * @return ExitException
     */
    public function __construct(string $message = "", int $code = 0, $data = null)
    {
        if (is_array($data)) {
            $this->data = $data;
        }
        parent::__construct($message, $code);
    }

    /**
     * Get data.
     *
     * @return array|null
     */
    public function getData()
    {
        return $this->data;
    }
}
