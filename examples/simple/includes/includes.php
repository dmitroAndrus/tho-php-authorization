<?php

/**
 * Load all required Classes.
 * php version 7.4
 *
 * Basic example of how you can add required Classes.
 *
 * @category SimpleExample
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

// Path to the ThoPHPAuthorization library includes (classes).
define('THOPHPAUTHORIZATION_CLASSES', AUTH_LIB_PATH . 'includes/');

// UUID service.
require_once(THOPHPAUTHORIZATION_CLASSES . 'Service/UUID.php');

// HTTP/Session service.
require_once(THOPHPAUTHORIZATION_CLASSES . 'Service/HTTPService.php');

// Data parts.
require_once(THOPHPAUTHORIZATION_CLASSES . 'Data/Name/StrictNameTrait.php');
require_once(THOPHPAUTHORIZATION_CLASSES . 'Data/ID/HasIDInterface.php');
require_once(THOPHPAUTHORIZATION_CLASSES . 'Data/ID/OnceIDTrait.php');
require_once(THOPHPAUTHORIZATION_CLASSES . 'Data/Name/HasNameInterface.php');
require_once(THOPHPAUTHORIZATION_CLASSES . 'Data/Name/NameTrait.php');
require_once(THOPHPAUTHORIZATION_CLASSES . 'Data/Password/HasPasswordInterface.php');
require_once(THOPHPAUTHORIZATION_CLASSES . 'Data/Password/PasswordTrait.php');
require_once(THOPHPAUTHORIZATION_CLASSES . 'Data/Password/BcryptPasswordTrait.php');

// Database service.
require_once(THOPHPAUTHORIZATION_CLASSES . 'Service/DBServiceInterface.php');
require_once(THOPHPAUTHORIZATION_CLASSES . 'Service/MySQLiService.php');

// User.
require_once(THOPHPAUTHORIZATION_CLASSES . 'User/UserInterface.php');
require_once(THOPHPAUTHORIZATION_CLASSES . 'User/AbstractUser.php');
require_once(THOPHPAUTHORIZATION_CLASSES . 'User/BasicUser.php');

// Users source.
require_once(THOPHPAUTHORIZATION_CLASSES . 'Source/UserSourceInterface.php');
require_once(THOPHPAUTHORIZATION_CLASSES . 'Source/UserKeepInterface.php');
require_once(THOPHPAUTHORIZATION_CLASSES . 'Source/AbstractUserDBSource.php');
require_once(THOPHPAUTHORIZATION_CLASSES . 'Source/BasicUserMySQLiSource.php');

// Users service.
require_once(THOPHPAUTHORIZATION_CLASSES . 'Service/UserService.php');
