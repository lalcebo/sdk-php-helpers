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
     * Find the occurrence of a string.
     *
     * @param  mixed $needle  Strings to find into $haystack
     * @param  string $haystack  The input string
     * @param  bool $caseInsensitive
     * @return bool True if $haystack contain any string on $needle.
     */
    public static function find($needle, string $haystack, bool $caseInsensitive = false): bool
    {
        $function = $caseInsensitive ? 'str_ireplace' : 'str_replace';

        return $function($needle, '', $haystack) !== $haystack;
    }
}
