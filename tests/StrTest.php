<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 3/27/21 2:48 PM
 */

declare(strict_types=1);

namespace Lalcebo\Helpers\Tests;

use Lalcebo\Helpers\Str;
use PHPUnit\Framework\TestCase;

class StrTest extends TestCase
{
    /** @var string */
    protected $providedTestString = 'Neque porro quisquam est qui dolorem ipsum quia dolor sit...';

    /** @test */
    public function findSimpleStringValue(): void
    {
        $find1 = Str::find('ipsum', $this->providedTestString);
        self::assertTrue($find1);

        $find2 = Str::find('Ipsum', $this->providedTestString, true);
        self::assertTrue($find2);

        $find3 = Str::find('Dolor', $this->providedTestString);
        self::assertFalse($find3);

        $find4 = Str::find('falseWord', $this->providedTestString);
        self::assertFalse($find4);
    }
}
