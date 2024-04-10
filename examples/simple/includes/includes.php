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

// UUID service.
require_once(THOAUTHORIZE_AUTOLOAD . 'Service/UUID.php');

// HTTP/Session service.
require_once(THOAUTHORIZE_AUTOLOAD . 'Service/HTTPService.php');

// Data parts.
require_once(THOAUTHORIZE_AUTOLOAD . 'Data/Name/StrictNameTrait.php');
require_once(THOAUTHORIZE_AUTOLOAD . 'Data/ID/HasIDInterface.php');
require_once(THOAUTHORIZE_AUTOLOAD . 'Data/ID/OnceIDTrait.php');
require_once(THOAUTHORIZE_AUTOLOAD . 'Data/Name/HasNameInterface.php');
require_once(THOAUTHORIZE_AUTOLOAD . 'Data/Name/NameTrait.php');
require_once(THOAUTHORIZE_AUTOLOAD . 'Data/Password/HasPasswordInterface.php');
require_once(THOAUTHORIZE_AUTOLOAD . 'Data/Password/PasswordTrait.php');
require_once(THOAUTHORIZE_AUTOLOAD . 'Data/Password/BcryptPasswordTrait.php');

// Database service.
require_once(THOAUTHORIZE_AUTOLOAD . 'Service/DBServiceInterface.php');
require_once(THOAUTHORIZE_AUTOLOAD . 'Service/MySQLiService.php');

// User.
require_once(THOAUTHORIZE_AUTOLOAD . 'User/UserInterface.php');
require_once(THOAUTHORIZE_AUTOLOAD . 'User/AbstractUser.php');
require_once(THOAUTHORIZE_AUTOLOAD . 'User/BasicUser.php');

// Users source.
require_once(THOAUTHORIZE_AUTOLOAD . 'Source/UserSourceInterface.php');
require_once(THOAUTHORIZE_AUTOLOAD . 'Source/UserKeepInterface.php');
require_once(THOAUTHORIZE_AUTOLOAD . 'Source/AbstractUserDBSource.php');
require_once(THOAUTHORIZE_AUTOLOAD . 'Source/BasicUserMySQLiSource.php');

// Users service.
require_once(THOAUTHORIZE_AUTOLOAD . 'Service/UserService.php');
