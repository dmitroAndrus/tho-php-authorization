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
        `first_name` varchar(255) NOT NULL,
        `last_name` varchar(255) NOT NULL,
        `birthday` date NOT NULL,
        `email` varchar(255) NOT NULL,
        `phone` varchar(255) NOT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `name` (`name`),
      UNIQUE KEY `email` (`email`),
      UNIQUE KEY `phone` (`phone`)
    ) DEFAULT CHARSET=utf8;
");

// Create user email table.
$dbService->query("
    CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "user_email` (
        `id` int NOT NULL AUTO_INCREMENT,
        `user_id` int NOT NULL,
        `type` varchar(255) NOT NULL,
        `email` varchar(255) NOT NULL,
      PRIMARY KEY (`id`),
      KEY `user_id` (`user_id`),
      KEY `type` (`type`)
    ) DEFAULT CHARSET=utf8;
");

// Create user phone table.
$dbService->query("
    CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "user_phone` (
        `id` int NOT NULL AUTO_INCREMENT,
        `user_id` int NOT NULL,
        `type` varchar(255) NOT NULL,
        `phone` varchar(255) NOT NULL,
      PRIMARY KEY (`id`),
      KEY `user_id` (`user_id`),
      KEY `type` (`type`)
    ) DEFAULT CHARSET=utf8;
");

// Create user address table.
$dbService->query("
    CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "user_address` (
        `id` int NOT NULL AUTO_INCREMENT,
        `user_id` int NOT NULL,
        `type` varchar(255) NOT NULL,
        `country` varchar(255) NOT NULL,
        `state` varchar(255) NOT NULL,
        `city` varchar(255) NOT NULL,
        `address` varchar(255) NOT NULL,
        `zip` varchar(255) NOT NULL,
      PRIMARY KEY (`id`),
      KEY `user_id` (`user_id`),
      KEY `type` (`type`)
    ) DEFAULT CHARSET=utf8;
");

// Create user keep signed table.
$dbService->query("
    CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "user_keep` (
        `id` varchar(36) NOT NULL,
        `user_id` int NOT NULL,
        `security` varchar(36) NOT NULL,
        `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `valid_until` datetime NOT NULL,
      PRIMARY KEY (`id`),
      KEY `user_id` (`user_id`),
      UNIQUE KEY `security` (`security`),
      KEY `valid_until` (`valid_until`)
    ) DEFAULT CHARSET=utf8;
");

// Create user request table.
$dbService->query("
    CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "user_request` (
        `id` varchar(36) NOT NULL,
        `user_id` int NOT NULL,
        `type` int NOT NULL,
        `security` varchar(36) NOT NULL,
        `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `valid_until` datetime NULL,
      PRIMARY KEY (`id`),
      KEY `user_id` (`user_id`),
      KEY `type` (`type`),
      UNIQUE KEY `security` (`security`),
      KEY `valid_until` (`valid_until`)
    ) DEFAULT CHARSET=utf8;
");
