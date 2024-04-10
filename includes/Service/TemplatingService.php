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
    public const SIMPLE_REGEXP = '(?:\{(.*?)\})';

    /**
     * Parse simple template.
     *
     * Template example:
     * My name is {name}. I live on planet {planet_name}.
     * Data example:
     * [
     *      'name' => 'Hugo',
     *      'planet_name' => 'Earth',
     * ]
     *
     * @param string $template - Template.
     * @param array $data - Array with template data.
     *
     * @return string.
     */
    public static function parseSimpleTemplate(string $template, array $data)
    {
        return preg_replace_callback(
            static::SIMPLE_REGEXP,
            function ($match) {
                if (isset($data[$match[0]])) {
                    return $data[$match[0]];
                }
            },
            $template
        );
    }
}
