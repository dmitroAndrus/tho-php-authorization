<?php

/**
 * This file contains MessageInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Message;

use ThoPHPAuthorization\Data\Message\HasMessageInterface;
use ThoPHPAuthorization\Data\Type\HasTypeInterface;

/**
 * MessageInterface is an interface to maintain and manipulate message data.
 */
interface MessageInterface extends HasMessageInterface, HasTypeInterface
{
}
