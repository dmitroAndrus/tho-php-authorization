<?php

/**
 * Autoload classes on request.
 * php version 7.4
 *
 * Basic example of how you can add required Classes.
 *
 * @category GenericExample
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

// Path to the ThoPHPAuthorization library includes (classes).
define('THOPHPAUTHORIZATION_AUTOLOAD', AUTH_LIB_PATH . 'includes/');
// UUID service.
require_once(THOPHPAUTHORIZATION_AUTOLOAD . 'Service/AutoloadService.php');

spl_autoload_register('ThoPHPAuthorization\Service\AutoloadService::autoload');
