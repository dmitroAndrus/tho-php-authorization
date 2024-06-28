<?php

/**
 * Initialize all necessary data.
 * php version 7.4
 *
 * @category GenericExample
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

use ThoPHPAuthorization\Service\MySQLiService;
use ThoPHPAuthorization\Service\HTTPService;
use ThoPHPAuthorization\User\User;
use ThoPHPAuthorization\Source\UserMySQLiSource;
use ThoPHPAuthorization\Service\UserService;
use ThoPHPAuthorization\Service\MailService;
use ThoPHPAuthorization\Source\UserAccessSource;
use ThoPHPAuthorization\Service\UserAccessService;

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

// Set available User identification types.
User::$canIdentifyByName = true;
User::$canIdentifyByEmail = true;
User::$canIdentifyByPhone = true;

// Create user source.
$user_source = new UserMySQLiSource($db_service);

// Create user service.
UserService::$keepSession = false; // Destroy session on signing out.
$user_service = new UserService('user', $user_source);

// Create mail service.
$mail_service = new MailService();

// Add SMTP transport and set it as default transport.
$mail_settings = [
    'hostname' => SMTP_HOSTNAME,
    'username' => SMTP_USERNAME,
    'password' => SMTP_PASSWORD,
    'port' => SMTP_PORT,
    'timeout' => SMTP_TIMEOUT,
];
$mail_service->addTransport('smtp', $mail_settings, true);

// User access source.
$user_access_source = new UserAccessSource($user_source);

// User access service.
$user_access_service = new UserAccessService($user_access_source);
