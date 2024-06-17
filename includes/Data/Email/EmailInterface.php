<?php

/**
 * This file contains EmailInterface interface.
 * php version 7.4
 *
 * @category Data
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Data\Email;

use ThoPHPAuthorization\Data\Email\HasEmailInterface;
use ThoPHPAuthorization\Data\Type\HasTypeInterface;

/**
 * EmailInterface is an interface to maintain and manipulate email data.
 *
 * Should provides access to email and email type data.
 *
 * Possible email types: personal, work, private, etc.
 */
interface EmailInterface extends HasEmailInterface, HasTypeInterface
{
}
