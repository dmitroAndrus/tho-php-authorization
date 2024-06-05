<?php

/**
 * This file contains HTTPService class.
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
 * HTTPService is a class, that contains HTTP functionality: session, get, post, etc.
 */
class HTTPService
{
    /**
     * Check if session is started.
     *
     * @return void
     */
    public static function isSessionStarted()
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    /**
     * Initialize session.
     *
     * @return void
     */
    public static function initSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * End session.
     *
     * @return void
     */
    public static function endSession()
    {
        if (static::isSessionStarted()) {
            session_unset();
            session_destroy();
        }
    }

    /**
     * Get value.
     *
     * @param string $name - Variable name.
     * @param mixed|null $default - Default value.
     *
     * @return mixed
     */
    public static function getValue($name, $default = null)
    {
        return isset($_GET[$name])
            ? $_GET[$name]
            : $default;
    }

    /**
     * Get POST value.
     *
     * @param string $name - Variable name.
     * @param mixed|null $default - Default value.
     *
     * @return mixed
     */
    public static function getPostValue($name, $default = null)
    {
        return isset($_POST[$name])
            ? $_POST[$name]
            : $default;
    }

    /**
     * Has SESSION value.
     *
     * @param string $name - Variable name.
     *
     * @return boolean
     */
    public static function hasSessionValue($name)
    {
        return static::isSessionStarted() && isset($_SESSION[$name]);
    }

    /**
     * Get SESSION value.
     *
     * @param string $name - Variable name.
     * @param mixed|null $default - Default value.
     *
     * @return mixed
     */
    public static function getSessionValue($name, $default = null)
    {
        return isset($_SESSION[$name])
            ? $_SESSION[$name]
            : $default;
    }

    /**
     * Remove SESSION value.
     *
     * @param string $name - Variable name.
     *
     * @return boolean
     */
    public static function removeSessionValue($name)
    {
        if (static::hasSessionValue($name)) {
            unset($_SESSION[$name]);
            return true;
        }
        return false;
    }

    /**
     * Convert local path to URL.
     *
     * @param string $path - Local path.
     *
     * @return mixed
     */
    public static function localToURL($path)
    {
        // Try to get SRC.
        try {
            $real = realpath($path);
            $real_root = $_SERVER['DOCUMENT_ROOT'];
            if (str_starts_with($real, $real_root)) {
                return $this->relativeToURL(substr($real, strlen($real_root)));
            }
        } catch (Exception $e) {
            // Failed to get SRC.
        }
        return null;
    }

    /**
     * Convert relative path to URL.
     *
     * @param string $path - Relative path.
     *
     * @return mixed
     */
    public static function relativeToURL($path)
    {
        $url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
            ? "https://"
            : "http://";
        // Append the host(domain name, ip) to the URL.
        return $_SERVER['HTTP_HOST'] . $path;
    }

    /**
     * Redirect to internal page.
     *
     * @param string $page - page to redirect.
     *
     * @return mixed
     */
    public static function redirectToPage($page)
    {
        if (headers_sent()) {
            return false;
        }
        $url = $this->relativeToURL($page);
        header("Location: {$url}");
        die();
    }

    /**
     * Output file content for download.
     *
     * @param string $basename - File basename.
     * @param string $content - File content.
     *
     * @return void
     */
    public static function outDownloadFileContent($basename, $content)
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $basename . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($content));
        echo $content;
        exit();
    }

    /**
     * Output file content.
     *
     * $content_type examples:
     * 'image/jpeg'
     * 'image/png'
     * 'image/jpeg'
     * 'video/mpeg'
     * etc.
     *
     * @param string $content_type - File content type.
     * @param string $content - File content.
     *
     * @return void
     */
    public static function outFileContent($content_type, $content)
    {
        header('Content-Type: ' . $content_type);
        header('Content-Length: ' . strlen($content));
        echo $content;
        exit();
    }
}
