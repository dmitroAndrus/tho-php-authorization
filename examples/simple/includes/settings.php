<?php

/**
 * Settings.
 * php version 7.4
 *
 * @category SimpleExample
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

// Path to the ThoPHPAuthorization library.
define('AUTH_LIB_PATH', __DIR__ . '/../../../');

// Database host name or IP address.
define('DB_HOSTNAME', 'mysql');
// Database port or null.
define('DB_PORT', '3306');
// Database socket or null.
define('DB_SOCKET', null);
// Database user name.
define('DB_USER', 'root');
// Database user password.
define('DB_PASSWORD', 'qwerty');

// Database name.
define('DB_DATABASE', 'simple_login');
// Database tables prefix.
define('DB_PREFIX', 'tho_');
// Database charset or null.
define('DB_CHARSET', null);

// Doesn't need to be changed.
// Path to the ThoPHPAuthorization library includes (classes).
define('THOPHPAUTHORIZATION_AUTOLOAD', AUTH_LIB_PATH . 'includes/');
