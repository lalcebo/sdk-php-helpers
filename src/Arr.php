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
     * @param array $flattenArray
     * @param string $delimiter
     * @return array
     */
    public static function dimensional(array $flattenArray, string $delimiter = '_'): array
    {
        $out = [];
        foreach ($flattenArray as $parentKey => $val) {
            $ref = &$out;
            foreach (explode($delimiter, (string)$parentKey) as $key) {
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
     * @param array $array
     * @param int $depth
     * @return array
     */
    public static function flatten(array $array, int $depth = -1): array
    {
        return array_values(static::flattenWithKeys($array, $depth));
    }

    /**
     * Convert multidimensional array into a single level array using current array keys.
     *
     * @param array $array Multidimensional key array.
     * @param int $depth
     * @param string $glue Separator to use on key.
     * @return array
     */
    public static function flattenWithKeys(array $array, int $depth = -1, string $glue = '_'): array
    {
        $path = [];
        $flat = [];

        $iterator = new RecursiveIteratorIterator(
            new RecursiveArrayIterator($array),
            RecursiveIteratorIterator::SELF_FIRST
        );

        $iterator->setMaxDepth($depth);

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
     * @param array $input
     * @param callable|null $callback
     * @param int $flag
     * @return array
     */
    public static function filterRecursive(array $input, callable $callback = null, int $flag = 0): array
    {
        foreach ($input as &$value) {
            if (is_array($value)) {
                $value = static::filterRecursive($value, $callback, $flag);
            }
        }

        return array_filter($input, $callback, $flag);
    }
}
