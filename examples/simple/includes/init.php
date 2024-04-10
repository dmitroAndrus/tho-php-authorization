<?php

/**
 * Initialize all necessary data.
 * php version 7.4
 *
 * @category SimpleExample
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

use ThoPHPAuthorization\Service\MySQLiService;
use ThoPHPAuthorization\Service\HTTPService;
use ThoPHPAuthorization\Source\BasicUserMySQLiSource;
use ThoPHPAuthorization\Service\UserService;

// Start session
HTTPService::initSession();

// Create MySQLi Database service.
$db_service = new MySQLiService(
    DB_HOSTNAME,
    DB_DATABASE,
    DB_USER,
    DB_PASSWORD,
    DB_PORT,
    DB_SOCKET,
    DB_CHARSET,
    DB_PREFIX
);

// Create user source.
$user_source = new BasicUserMySQLiSource($db_service);

// Create user service.
UserService::$keepSession = false; // Destroy session on signing out.
$user_service = new UserService('user', $user_source);
