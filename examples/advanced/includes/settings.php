<?php

/**
 * Settings.
 * php version 7.4
 *
 * @category GenericExample
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

// URL to this example.
define('URL_PATH', '/examples/advanced/');

// Path to the ThoPHPAuthorization library.
define('AUTH_LIB_PATH', __DIR__ . '/../../../');

/* Database settings */

// Database host name or IP address.
define('DB_HOSTNAME', 'mysql');
// Database port or null.
define('DB_PORT', '3306');
// Database socket or null.
define('DB_SOCKET', null);
// Database user name.
define('DB_USER', 'username');
// Database user password.
define('DB_PASSWORD', 'password');

// Database name.
define('DB_DATABASE', 'tho_authorization');
// Database tables prefix.
define('DB_PREFIX', 'tho_advanced_');
// Database charset or null.
define('DB_CHARSET', null);


/* SMTP settings */
define('SMTP_SENDER_EMAIL', 'no-reply@my-mail.com');
define('SMTP_REPLYTO_EMAIL', 'reply-to@my-mail.com');
define('SMTP_ADMIN_EMAIL', 'admin@my-mail.com');

// SMTP host name.
define('SMTP_HOSTNAME', 'tls://smtp.my-mail.com');
// SMTP host port.
define('SMTP_PORT', 587);
// SMTP timeout.
define('SMTP_TIMEOUT', 5);
// SMTP authorization user name and password.
define('SMTP_USERNAME', 'username');
define('SMTP_PASSWORD', 'password');

// Path to the current ThoPHPAuthorization example includes (classes).
define('THOPHPAUTHORIZATIONEXAMPLE_AUTOLOAD', __DIR__);
