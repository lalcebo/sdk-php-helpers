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
            'last' => 'Peters',
            'age' => 40,
            'car' => [
                'brand' => 'Audi',
                'color' => 'Black',
                'miles' => 1000
            ]
        ],
        'phone' => '+1 (989) 554-2724',
        'registered' => 'Friday, August 2, 2019 7 =>51 PM',
        'tags' => [
            'reprehenderit',
            'incididunt',
            'eu'
        ]
    ];

    /** @var array */
    protected $providedFlattenedArray = [
        'id' => '605f6f26a6a97004210e0c99',
        'index' => 4,
        'guid' => 'dc03ae65-e057-4270-a912-db15e4f5f029',
        'name_first' => 'Bowen',
        'name_last' => 'Peters',
        'name_age' => 40,
        'name_car_brand' => 'Audi',
        'name_car_color' => 'Black',
        'name_car_miles' => 1000,
        'phone' => '+1 (989) 554-2724',
        'registered' => 'Friday, August 2, 2019 7 =>51 PM',
        'tags_0' => 'reprehenderit',
        'tags_1' => 'incididunt',
        'tags_2' => 'eu'
    ];

    /** @test */
    public function toFlattenResult(): void
    {
        $toFlat = Arr::flatten($this->providedTestArray);
        self::assertEquals(
            [
                '605f6f26a6a97004210e0c99',
                4,
                'dc03ae65-e057-4270-a912-db15e4f5f029',
                'Bowen',
                'Peters',
                40,
                'Audi',
                'Black',
                1000,
                '+1 (989) 554-2724',
                'Friday, August 2, 2019 7 =>51 PM',
                'reprehenderit',
                'incididunt',
                'eu'
            ],
            $toFlat
        );
    }

    /** @test */
    public function toFlattenWithKeysResult(): void
    {
        $toFlat = Arr::flattenWithKeys($this->providedTestArray);
        self::assertEquals($this->providedFlattenedArray, $toFlat);
    }

    /** @test */
    public function flattenWithKeysAndDepthResult(): void
    {
        $toFlat1 = Arr::flattenWithKeys($this->providedTestArray, 0);
        self::assertEquals(
            [
                'id' => '605f6f26a6a97004210e0c99',
                'index' => 4,
                'guid' => 'dc03ae65-e057-4270-a912-db15e4f5f029',
                'phone' => '+1 (989) 554-2724',
                'registered' => 'Friday, August 2, 2019 7 =>51 PM'
            ],
            $toFlat1
        );

        $toFlat2 = Arr::flattenWithKeys($this->providedTestArray, 1);
        self::assertEquals(
            [
                'id' => '605f6f26a6a97004210e0c99',
                'index' => 4,
                'guid' => 'dc03ae65-e057-4270-a912-db15e4f5f029',
                'name_first' => 'Bowen',
                'name_last' => 'Peters',
                'name_age' => 40,
                'phone' => '+1 (989) 554-2724',
                'registered' => 'Friday, August 2, 2019 7 =>51 PM',
                'tags_0' => 'reprehenderit',
                'tags_1' => 'incididunt',
                'tags_2' => 'eu'
            ],
            $toFlat2
        );
    }

    /** @test */
    public function flattenToMultiDimensionalResult(): void
    {
        $toMultiDimensional1 = Arr::dimensional($this->providedFlattenedArray);
        self::assertEquals($this->providedTestArray, $toMultiDimensional1);

        $toMultiDimensional2 = Arr::dimensional(
            [
                '605f6f26a6a97004210e0c99',
                4,
                '2_0' => 'Audi',
                '2_1' => 1000
            ]
        );
        self::assertEquals(['605f6f26a6a97004210e0c99', 4, ['Audi', 1000]], $toMultiDimensional2);
    }

    /** @test */
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
                return (is_array($value) && !empty($value)) || is_int($value);
            }
        );

        self::assertEquals(['index' => 4, 'name' => ['age' => 40, 'car' => ['miles' => 1000]]], $filter2);
    }
}
