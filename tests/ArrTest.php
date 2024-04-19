<?php

/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

use Lalcebo\Helpers\Arr;

beforeEach(function () {
    $this->providedTestArray = [
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
                'miles' => 1000,
            ],
        ],
        'phone' => '+1 (989) 554-2724',
        'registered' => 'Friday, August 2, 2019 7:51 PM',
        'tags' => [
            'reprehenderit',
            'incididunt',
            'eu',
        ],
    ];

    $this->providedFlattenedArray = [
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
        'registered' => 'Friday, August 2, 2019 7:51 PM',
        'tags_0' => 'reprehenderit',
        'tags_1' => 'incididunt',
        'tags_2' => 'eu',
    ];
});

it('should can convert to flatten', function () {
    expect(Arr::flatten($this->providedTestArray))
        ->toEqual([
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
            'Friday, August 2, 2019 7:51 PM',
            'reprehenderit',
            'incididunt',
            'eu',
        ]);
});

it('should can convert to flatten with keys', function () {
    expect(Arr::flattenWithKeys($this->providedTestArray))
        ->toEqual($this->providedFlattenedArray);
});

it('should can convert to flatten using depth result', function () {
    expect(Arr::flattenWithKeys($this->providedTestArray, 0))
        ->toEqual([
            'id' => '605f6f26a6a97004210e0c99',
            'index' => 4,
            'guid' => 'dc03ae65-e057-4270-a912-db15e4f5f029',
            'phone' => '+1 (989) 554-2724',
            'registered' => 'Friday, August 2, 2019 7:51 PM',
        ])
        ->and(Arr::flattenWithKeys($this->providedTestArray, 1))
        ->toEqual([
            'id' => '605f6f26a6a97004210e0c99',
            'index' => 4,
            'guid' => 'dc03ae65-e057-4270-a912-db15e4f5f029',
            'name_first' => 'Bowen',
            'name_last' => 'Peters',
            'name_age' => 40,
            'phone' => '+1 (989) 554-2724',
            'registered' => 'Friday, August 2, 2019 7:51 PM',
            'tags_0' => 'reprehenderit',
            'tags_1' => 'incididunt',
            'tags_2' => 'eu',
        ])
        ->and(Arr::flattenWithKeys([
            'id' => '605f6f26a6a97004210e0c99',
            'index' => 4,
            'guid' => 'dc03ae65-e057-4270-a912-db15e4f5f029',
            'name' => new class()
            {
                public string $first = 'Bowen';

                public string $last = 'Peters';

                public int $age = 40;

                public function toArray(): array
                {
                    return (array) $this;
                }
            },
        ]))
        ->toEqual([
            'id' => '605f6f26a6a97004210e0c99',
            'index' => 4,
            'guid' => 'dc03ae65-e057-4270-a912-db15e4f5f029',
            'name_first' => 'Bowen',
            'name_last' => 'Peters',
            'name_age' => 40,
        ]);
});

it('should convert a flatten to multi-dimensional', function () {
    expect(Arr::dimensional($this->providedFlattenedArray))
        ->toEqual($this->providedTestArray)
        ->and(Arr::dimensional([
            '605f6f26a6a97004210e0c99',
            4,
            '2_0' => 'Audi',
            '2_1' => 1000,
        ]))
        ->toEqual(['605f6f26a6a97004210e0c99', 4, ['Audi', 1000]]);
});

it('should filter recursive', function () {
    expect(Arr::filterRecursive($this->providedTestArray, static fn ($value, $key) => $key === 'id', ARRAY_FILTER_USE_BOTH))
        ->toEqual(['id' => '605f6f26a6a97004210e0c99'])
        ->and(Arr::filterRecursive($this->providedTestArray, static fn ($value) => (is_array($value) && ! empty($value)) || is_int($value)))
        ->toEqual(['index' => 4, 'name' => ['age' => 40, 'car' => ['miles' => 1000]]]);
});
