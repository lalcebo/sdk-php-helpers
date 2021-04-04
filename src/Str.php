<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 3/27/21 2:49 PM
 */

declare(strict_types=1);

namespace Lalcebo\Helpers;

class Str
{
    /**
     * Determine if a given string contains a given substring.
     *
     * @param string|array $needles Strings to find into $haystack
     * @param string $haystack The input string
     * @return bool True if $haystack contain any substring on $needles.
     */
    public static function contains($needles, string $haystack): bool
    {
        return str_replace((array)$needles, '', $haystack) !== $haystack;
    }

    /**
     * Determine if a given string contains all array values.
     *
     * @param string[] $needles
     * @param string $haystack
     * @return bool True if $haystack contain all substring on $needles.
     */
    public static function containsAll(array $needles, string $haystack): bool
    {
        foreach ($needles as $needle) {
            if (!static::contains($needle, $haystack)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine if a given string contains a given substring case insensitive.
     *
     * @param string|array $needles
     * @param string $haystack The input string
     * @return bool True if $haystack contain any case insensitive substring on $needles.
     */
    public static function containsInsensitive($needles, string $haystack): bool
    {
        return str_ireplace((array)$needles, '', $haystack) !== $haystack;
    }

    /**
     * Determine if a given string contains all array values case insensitive.
     *
     * @param string[] $needles
     * @param string $haystack
     * @return bool True if $haystack contain all case insensitive substring on $needles.
     */
    public static function containsAllInsensitive(array $needles, string $haystack): bool
    {
        foreach ($needles as $needle) {
            if (!static::containsInsensitive($needle, $haystack)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Encode a string to base64 url-safe format.
     *
     * @param string $str
     * @return string
     */
    public static function urlBase64Encode(string $str): string
    {
        return str_replace('=', '', strtr(base64_encode($str), '+/', '-_'));
    }

    /**
     * Decode a string with base64 url-safe format.
     *
     * @param string $str
     * @return string
     */
    public static function urlBase64Decode(string $str): string
    {
        $padding = strlen($str) % 4;
        if ($padding > 0) {
            $str .= str_repeat('=', 4 - $padding);
        }

        return base64_decode(strtr($str, '-_', '+/'));
    }
}
