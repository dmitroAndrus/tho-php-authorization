<?php

/**
 * This file contains UUID class.
 * PHP version 7.4
 *
 * The most of the code were taken from Andrew Moore https://www.php.net/manual/en/function.uniqid.php#94959
 *
 * @category Service
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Service;

/**
 * UserService is a class, that contains functionality to work with users.
 */
class UUID
{
    /**
     * Check UUID is valid.
     *
     * @param string $uuid - UUID.
     *
     * @return boolean - Is valid.
     */
    public static function isValid($uuid)
    {
        return preg_match(
            '/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i',
            $uuid
        ) === 1;
    }

    /**
     * Conver UUID to bits.
     *
     * @param string $uuid - UUID to convert.
     *
     * @return string - Bits value.
     */
    public static function convertToBits($uuid)
    {
        // Get hexadecimal components of uuid
        $nhex = str_replace(array('-','{','}'), '', $uuid);

        // Binary Value
        $nstr = '';

        // Convert Namespace UUID to bits
        for ($i = 0; $i < strlen($nhex); $i += 2) {
            $nstr .= chr(hexdec($nhex[$i] . $nhex[$i + 1]));
        }
        return $nstr;
    }

    /**
     * Create UUID from hash.
     *
     * @param string $uuid - UUID to convert.
     *
     * @return string - Bits value.
     */
    public static function fromHash($hash)
    {
        return sprintf(
            '%08s-%04s-%04x-%04x-%12s',
            // 32 bits for "time_low"
            substr($hash, 0, 8),
            // 16 bits for "time_mid"
            substr($hash, 8, 4),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 3
            (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x3000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,
            // 48 bits for "node"
            substr($hash, 20, 12)
        );
    }

    /**
     * Generates VALID RFC 4211 COMPLIANT Universally Unique IDentifiers (UUID) version 3.
     *
     * Given the same namespace and name, the output is always the same.
     * Generates with md5 hash help.
     *
     * @param string $namespace - Valid UUID.
     * @param string $name - Unique name.
     *
     * @return string - UUID.
     */
    public static function v3($namespace, $name)
    {
        if (!static::isValid($namespace)) {
            return false;
        }

        // Binary Value
        $nstr = static::convertToBits($namespace);

        // Calculate hash value
        $hash = md5($nstr . $name);

        return static::fromHash($hash);
    }

    /**
     * Generates pseudo-random VALID RFC 4211 COMPLIANT Universally Unique IDentifiers (UUID) version 3.
     *
     * @return string - UUID.
     */
    public static function v4()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    /**
     * Generates VALID RFC 4211 COMPLIANT Universally Unique IDentifiers (UUID) version 5.
     *
     * Given the same namespace and name, the output is always the same.
     * Generates with sha1 hash help.
     *
     * @param string $namespace - Valid UUID.
     * @param string $name - Unique name.
     *
     * @return string - UUID.
     */
    public static function v5($namespace, $name)
    {
        if (!self::isValid($namespace)) {
            return false;
        }
        // Get hexadecimal components of namespace
        $nstr = static::convertToBits($namespace);

        // Calculate hash value
        $hash = sha1($nstr . $name);

        return static::fromHash($hash);
    }
}
