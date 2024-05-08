<?php

/**
 * This file contains AutoloadService class.
 * PHP version 7.4
 *
 * @category Service
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Service;

/**
 * AutoloadService is a class, that contains functionality to autoload required classes.
 *
 * Example:
 * require_once('<path to the root ThoPHPAuthorization lib folder>/includes/ThoPHPAuthorization/Service/AutoloadService.php');
 * spl_autoload_register('ThoPHPAuthorization\Service\AutoloadService::autoload');
 *
 */
class AutoloadService
{
    /**
     * Cached path to classes root directories.
     *
     * @var string[]
     */
    protected static $paths = false;

    /**
     * Add path for autoload.
     *
     * @param string $name - Namespace root.
     * @param string $path - Path to classes root directory.
     *
     * @return boolean - path added or not.
     */
    public static function addPath(string $name, string $path)
    {
        $uname = strtolower($name);
        $path = realpath($path);
        if ($path && is_dir($path)) {
            static::$paths[$uname] = $path;
            return true;
        }
        return true;
    }

    /**
     * Add path for autoload from constant.
     *
     * @param string $name - Namespace root.
     *
     * For 'use <namespace root>\Service\HTTPService;' there should be defined constant
     * like 'define('<namespace root uppercase>_AUTOLOAD', '<path to classes root directories>');'.
     * Example for 'use ThoPHPAuthorization\Service\HTTPService;':
     * define('THOPHPAUTHORIZATION_AUTOLOAD', __DIR__ . '/classes/');
     *
     * @return boolean - path added or not.
     */
    public static function addPathFromAutoloadConst(string $name)
    {
        $uname = strtoupper($name);
        return defined("{$uname}_AUTOLOAD") && static::addPath($uname, constant("{$uname}_AUTOLOAD"));
    }

    /**
     * Check if path exists.
     *
     * @param string $name - Namespace root.
     *
     * @return boolean - path exists.
     */
    public static function hasPath(string $name)
    {
        $cached = static::$paths;
        return isset($cached[$name]);
    }

    /**
     * Get path.
     *
     * @param string $name - Namespace root.
     *
     * @return string|null - Path or null if not exists.
     */
    public static function getPath(string $name)
    {
        $uname = strtolower($name);
        if (static::hasPath($uname)) {
            return static::$paths[$uname];
        }
        return null;
    }

    /**
     * Require once file from the path.
     *
     * @param string $name - Namespace root.
     * @param string $path - Path to the file.
     *
     * @return boolean - path exists.
     */
    public static function loadPathOnce(string $name, string $path)
    {
        $root_path = static::getPath($name);
        if ($root_path) {
            $file_path = $root_path . DIRECTORY_SEPARATOR . trim($path, '/\\') . '.php';
            if (file_exists($file_path)) {
                require_once($file_path);
            }
        }
        return false;
    }

    /**
     * Join path parts ignoring first element.
     *
     * @param string $parts - Path parts.
     *
     * @return boolean - path exists.
     */
    public static function joinSubPath($parts)
    {
        $rest = array_slice($parts, 1);
        return implode(DIRECTORY_SEPARATOR, $rest);
    }

    /**
     * Autoload class.
     *
     * All paths to classes root directories should be added with `addPath` method of this class
     * or defined as constant. Check `addPathFromAutoloadConst` method for the constant format.
     *
     * @param string $class - Class name.
     *
     * @return boolean - class found and loaded.
     */
    public static function autoload($class)
    {
        $parts = explode('\\', $class);
        if (
            count($parts) > 1
            && (static::hasPath($parts[0])
                || static::addPathFromAutoloadConst($parts[0]))
        ) {
            return static::loadPathOnce($parts[0], static::joinSubPath($parts));
        }
        return false;
    }
}
