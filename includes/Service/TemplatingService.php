<?php

/**
 * This file contains TemplatingService class.
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
 * TemplatingService is a class, that contains templating functionality.
 */
class TemplatingService
{
    /**
     * Simple template regexp.
     *
     * Used to parse simple templates like:
     * My name is {name}. I live on planet {planet_name}.
     *
     * @var string
     */
    public const SIMPLE_REGEXP = '/(?:\\{(.*?)\\})/im';

    /**
     * Parse simple template.
     *
     * Template example:
     * My name is {name}. I live on planet {planet_name}.
     *
     * Data example:
     * ```php
     * [
     *     'name' => 'Hugo',
     *     'planet_name' => 'Earth',
     * ]
     * ```
     *
     * @param string $template Template.
     * @param array $data Array with template data.
     *
     * @return string
     */
    public static function parseSimpleTemplate(string $template, array $data)
    {
        return preg_replace_callback(
            static::SIMPLE_REGEXP,
            function ($match) use ($data) {
                if (isset($data[$match[1]])) {
                    return $data[$match[1]];
                }
            },
            $template
        );
    }

    /**
     * Validate HTML.
     *
     * @param string $html HTML to validate.
     *
     * @return boolean
     */
    public static function validateHTML($html)
    {
        if (!is_string($html) || empty($html)) {
            return false;
        }
        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        return empty(libxml_get_errors());
    }

    /**
     * Output text line.
     *
     * @param mixed $value Value to output.
     *
     * @return void
     */
    public static function outLine($value = '')
    {
        echo $value . "<br/>";
    }

    protected static $allowedTemplateExtensions = ['txt', 'html'];

    /**
     * Read template file.
     *
     * You can provide $data for use in static::parseSimpleTemplate.
     *
     * @param string $path Template path.
     * @param string $data Template data.
     *
     * @return string|null Template content or null on failure.
     */
    public static function readTemplateFile(string $path, array $data = null)
    {
        $real = realpath($path);
        // Check file exsists and if file extension is allowed.
        if (!$real || !in_array(pathinfo($real, PATHINFO_EXTENSION), static::$allowedTemplateExtensions)) {
            return null;
        }
        ob_start();
        readfile($real);
        $result = ob_get_contents();
        ob_end_clean();
        return $data ? static::parseSimpleTemplate($result, $data) : $result;
    }
}
