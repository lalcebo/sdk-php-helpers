<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 3/27/21 2:14 PM
 */

declare(strict_types=1);

namespace Lalcebo\Helpers;

use RecursiveArrayIterator;
use RecursiveIteratorIterator;

class Arr
{
    /**
     * Convert single level array to multidimensional array.
     *
     * @param array $array
     * @param string $delimiter
     * @return array
     */
    public static function multiDimensional(array $array, string $delimiter = '_'): array
    {
        $out = [];
        foreach ($array as $parent_key => $val) {
            $ref = &$out;
            foreach (explode($delimiter, $parent_key) as $key) {
                if (!array_key_exists($key, $ref)) {
                    $ref[$key] = [];
                }
                $ref = &$ref[$key];
            }
            $ref = $val;
        }

        return $out;
    }

    /**
     * Convert multidimensional array into a single level array.
     *
     * @param array $array Multidimensional key array.
     * @param string $glue Separator to use on key.
     * @return array
     */
    public static function flatten(array $array, string $glue = '_'): array
    {
        $path = [];
        $flat = [];

        $iterator = new RecursiveIteratorIterator(
            new RecursiveArrayIterator($array),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $key => $value) {
            $path[$iterator->getDepth()] = $key;
            if (!is_array($value)) {
                $flat[implode($glue, array_slice($path, 0, $iterator->getDepth() + 1))] = $value;
            }
        }

        return $flat;
    }

    /**
     * Filters recursive elements of an array using a callback function.
     *
     * @param  array  $input
     * @param  callable|null  $callback
     * @param  int  $flag
     * @return array
     */
    public static function filterRecursive(array $input, callable $callback = null, int $flag = 0): array
    {
        foreach ($input as &$value) {
            if (is_array($value)) {
                $value = self::filterRecursive($value, $callback, $flag);
            }
        }

        return array_filter($input, $callback, $flag);
    }
}
