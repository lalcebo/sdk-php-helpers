<?php

declare(strict_types=1);

namespace Lalcebo\Helpers;

use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use TypeError;

class Arr
{
    /**
     * Convert a single level array to multidimensional array.
     *
     * @param  array<int|string, mixed>  $flatten
     * @return array<int|string, mixed>
     */
    public static function dimensional(array $flatten, string $delimiter = '_'): array
    {
        if ($delimiter === '' || $delimiter === '0') {
            throw new TypeError('Delimiter must be a non-empty string');
        }

        $out = [];

        foreach ($flatten as $parentKey => $val) {
            $ref = &$out;
            $keys = explode($delimiter, (string) $parentKey);

            foreach ($keys as $key) {
                $ref = &$ref[$key];
            }

            $ref = $val;
        }

        return $out;
    }

    /**
     * Convert multidimensional array into a single level array.
     *
     * @param  array<int|string,mixed>  $array
     * @return array<int,mixed>
     */
    public static function flatten(array $array, int $depth = -1): array
    {
        return array_values(static::flattenWithKeys($array, $depth));
    }

    /**
     * Convert a multidimensional array into a single level array using current array keys.
     *
     * @param  array<int|string,mixed>  $array  Multidimensional key array.
     * @param  string  $glue  Separator to use on a key.
     * @return array<int,mixed>
     */
    public static function flattenWithKeys(array $array, int $depth = -1, string $glue = '_'): array
    {
        $path = [];
        /** @var array<int,mixed> $flat */
        $flat = [];

        $iterator = new RecursiveIteratorIterator(
            new RecursiveArrayIterator($array),
            RecursiveIteratorIterator::SELF_FIRST
        );

        $iterator->setMaxDepth($depth);

        foreach ($iterator as $key => $value) {
            $path[$iterator->getDepth()] = $key;
            $value = is_object($value) && method_exists($value, 'toArray')
                ? $value->toArray()
                : $value;

            if (! is_array($value)) {
                $flat[implode($glue, array_slice($path, 0, $iterator->getDepth() + 1))] = $value;
            }
        }

        return $flat;
    }

    /**
     * Filters recursive elements of an array using a callback function.
     *
     * @param  array<int|string,mixed>  $input
     * @return array<int|string,mixed>
     */
    public static function filterRecursive(array $input, ?callable $callback = null, int $flag = 0): array
    {
        foreach ($input as &$value) {
            if (is_array($value)) {
                $value = static::filterRecursive($value, $callback, $flag);
            }
        }

        return array_filter($input, $callback, $flag);
    }
}
