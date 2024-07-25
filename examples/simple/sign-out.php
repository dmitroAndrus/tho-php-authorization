<?php

/**
 * This file contains example of simple user authorization.
 * php version 7.4
 *
 * Sign out active user.
 *
 * @category SimpleExample
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

require_once('./includes/start.php');

use ThoPHPAuthorization\Service\HTTPService;

$user_service->signOut();

HTTPService::redirectToPage(URL_PATH . 'index.php');
