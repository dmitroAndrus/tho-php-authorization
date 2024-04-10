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

// Create MySQLi Database service
$dbService = new MySQLiService(
    DB_HOSTNAME,
    DB_DATABASE,
    DB_USER,
    DB_PASSWORD,
    DB_PORT,
    DB_SOCKET,
    DB_CHARSET,
    DB_PREFIX
);

// Create user table.
$dbService->query("
    CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "user` (
        `id` int NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `security` varchar(255) NOT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `name` (`name`)
    ) DEFAULT CHARSET=utf8;
");

// Create user keep signed table.
$dbService->query("
    CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "user_keep` (
        `id` varchar(255) NOT NULL,
        `user_id` int NOT NULL,
        `security` varchar(255) NOT NULL,
        `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `valid_until` datetime NOT NULL,
      PRIMARY KEY (`id`),
      KEY `user_id` (`user_id`),
      UNIQUE KEY `security` (`security`),
      KEY `valid_until` (`valid_until`)
    ) DEFAULT CHARSET=utf8;
");
