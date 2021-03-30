<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 3/27/21 2:14 PM
 */

declare(strict_types=1);

namespace Lalcebo\Helpers\Tests;

use Lalcebo\Helpers\Arr;
use PHPUnit\Framework\TestCase;

class ArrTest extends TestCase
{
    /** @var array */
    protected $providedTestArray = [
        'id' => '605f6f26a6a97004210e0c99',
        'index' => 4,
        'guid' => 'dc03ae65-e057-4270-a912-db15e4f5f029',
        'name' => [
            'first' => 'Bowen',
            'last' => 'Peters'
        ],
        'phone' => '+1 (989) 554-2724',
        'registered' => 'Friday, August 2, 2019 7 =>51 PM',
        'tags' => [
            'reprehenderit',
            'incididunt',
            'eu'
        ]
    ];

    /** @test */
    public function toFlattenResult(): void
    {
        $toFlat = Arr::flatten($this->providedTestArray);
        self::assertEquals(
            [
                'id' => '605f6f26a6a97004210e0c99',
                'index' => 4,
                'guid' => 'dc03ae65-e057-4270-a912-db15e4f5f029',
                'name_first' => 'Bowen',
                'name_last' => 'Peters',
                'phone' => '+1 (989) 554-2724',
                'registered' => 'Friday, August 2, 2019 7 =>51 PM',
                'tags_0' => 'reprehenderit',
                'tags_1' => 'incididunt',
                'tags_2' => 'eu'
            ],
            $toFlat
        );
    }

    /** @test  */
    public function toMultidimensionalResult(): void
    {
        $toMultiDimensional = Arr::multiDimensional(
            [
                'id' => '605f6f26a6a97004210e0c99',
                'index' => 4,
                'guid' => 'dc03ae65-e057-4270-a912-db15e4f5f029',
                'name_first' => 'Bowen',
                'name_last' => 'Peters',
                'phone' => '+1 (989) 554-2724',
                'registered' => 'Friday, August 2, 2019 7 =>51 PM',
                'tags_0' => 'reprehenderit',
                'tags_1' => 'incididunt',
                'tags_2' => 'eu'
            ]
        );

        self::assertEquals(
            $this->providedTestArray,
            $toMultiDimensional
        );
    }

    /**
     * @test
     * @noinspection PhpUnusedParameterInspection
     */
    public function filterRecursiveResult(): void
    {
        $filter1 = Arr::filterRecursive(
            $this->providedTestArray,
            static function ($value, $key) {
                return $key === 'id';
            },
            ARRAY_FILTER_USE_BOTH
        );

        self::assertEquals(['id' => '605f6f26a6a97004210e0c99'], $filter1);

        $filter2 = Arr::filterRecursive(
            $this->providedTestArray,
            static function ($value) {
                return is_int($value);
            }
        );

        self::assertEquals(['index' => 4], $filter2);
    }
}
