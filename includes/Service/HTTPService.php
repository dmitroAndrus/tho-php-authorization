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
     * Initialize session.
     *
     * @return void
     */
    public static function isSessionStarted()
    {
        return session_status() === PHP_SESSION_NONE;
    }

    /**
     * Initialize session.
     *
     * @return void
     */
    public static function initSession()
    {
        if (static::isSessionStarted()) {
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
        if (session_status() !== PHP_SESSION_NONE) {
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
     * Redirect to internal page.
     *
     * @param string $page - page to redirect.
     *
     * @return mixed
     */
    public static function redirectToPage($page)
    {
        if (headers_sent()) {
            false;
        }
        $url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
            ? "https://"
            : "http://";
        // Append the host(domain name, ip) to the URL.
        $url .= $_SERVER['HTTP_HOST'] . $page;
        header("Location: {$url}");
        die();
    }
}
