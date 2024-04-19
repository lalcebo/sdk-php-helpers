<?php

declare(strict_types=1);

namespace Lalcebo\Helpers;

class Str
{
    /**
     * Determine if a given string contains a given substring.
     *
     * @param  array<string>|string  $needles  Strings to find into $haystack
     * @param  string  $haystack  The input string
     * @return bool True if $haystack contain any substring on $needles.
     */
    public static function contains(array|string $needles, string $haystack): bool
    {
        return str_replace((array) $needles, '', $haystack) !== $haystack;
    }

    /**
     * Determine if a given string contains all array values.
     *
     * @param  array<string>  $needles
     * @return bool True if $haystack contain all substring on $needles.
     */
    public static function containsAll(array $needles, string $haystack): bool
    {
        foreach ($needles as $needle) {
            if (! static::contains($needle, $haystack)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine if a given string contains a given substring case-insensitive.
     *
     * @param  array<string>  $needles
     * @param  string  $haystack  The input string
     * @return bool True if $haystack contain any case insensitive substring on $needles.
     */
    public static function containsInsensitive(array|string $needles, string $haystack): bool
    {
        return str_ireplace((array) $needles, '', $haystack) !== $haystack;
    }

    /**
     * Determine if a given string contains all array values a case-insensitive.
     *
     * @param  array<string>  $needles
     * @return bool True if $haystack contain all case insensitive substring on $needles.
     */
    public static function containsAllInsensitive(array $needles, string $haystack): bool
    {
        foreach ($needles as $needle) {
            if (! static::containsInsensitive($needle, $haystack)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Encode a string to base64 url-safe format.
     */
    public static function urlBase64Encode(string $str): string
    {
        return str_replace('=', '', strtr(base64_encode($str), '+/', '-_'));
    }

    /**
     * Decode a string with base64 url-safe format.
     */
    public static function urlBase64Decode(string $str): string
    {
        $padding = strlen($str) % 4;
        if ($padding > 0) {
            $str .= str_repeat('=', 4 - $padding);
        }

        return base64_decode(strtr($str, '-_', '+/'));
    }

    /**
     * Check if a string is a valid base64 encoded.
     */
    public static function validBase64(string $str): bool
    {
        // Check if there are valid base64 characters
        if (! preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $str)) {
            return false;
        }

        // Decode the string in strict mode and check the results
        $decoded = base64_decode($str, true);
        if ($decoded === false) {
            return false;
        }

        // Encode the string again
        return base64_encode($decoded) === $str;
    }
}
