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

    /** @var string */
    protected $url = 'https://github.com/lalcebo';

    /** @var string */
    protected $urlBase64Encode = 'aHR0cHM6Ly9naXRodWIuY29tL2xhbGNlYm8';

    /** @test */
    public function containsSimpleValue(): void
    {
        self::assertTrue(Str::contains('ipsum', $this->providedTestString));
        self::assertFalse(Str::contains('Dolor', $this->providedTestString));
    }

    /** @test */
    public function containsArrayValues(): void
    {
        self::assertTrue(Str::contains(['porro', 'ipsum'], $this->providedTestString));
        self::assertFalse(Str::contains(['unknown', 'hello'], $this->providedTestString));
    }

    /** @test */
    public function containsAllValues(): void
    {
        self::assertTrue(Str::containsAll(['Neque', 'ipsum'], $this->providedTestString));
        self::assertFalse(Str::containsAll(['quisquam', 'Hello'], $this->providedTestString));
    }

    /** @test */
    public function containsInsensitiveSimpleValue(): void
    {
        self::assertTrue(Str::containsInsensitive('neque', $this->providedTestString));
        self::assertFalse(Str::containsInsensitive('falseWord', $this->providedTestString));
    }

    /** @test */
    public function containsInsensitiveArrayValues(): void
    {
        self::assertTrue(Str::containsInsensitive(['neque', 'Ipsum'], $this->providedTestString));
        self::assertFalse(Str::containsInsensitive(['Unknown', 'Hello'], $this->providedTestString));
    }

    /** @test */
    public function containsAllInsensitiveValues(): void
    {
        self::assertTrue(Str::containsAllInsensitive(['neque', 'Ipsum'], $this->providedTestString));
        self::assertFalse(Str::containsAllInsensitive(['quisquam', 'Hello'], $this->providedTestString));
    }

    /** @test */
    public function urlBase64Encode(): void
    {
        self::assertEquals($this->urlBase64Encode, Str::urlBase64Encode($this->url));
    }

    /** @test */
    public function urlBase64Decode(): void
    {
        self::assertEquals($this->url, Str::urlBase64Decode($this->urlBase64Encode));
    }

    /** @test */
    public function validBase64String(): void
    {
        self::assertTrue(Str::validBase64('VmFsaWQgYmFzZTY0IHRleHQ='));
    }

    /** @test */
    public function invalidBase64String(): void
    {
        self::assertFalse(Str::validBase64('falseBase64String'));
        self::assertFalse(Str::validBase64('$&^#invalidBase64String'));
        self::assertFalse(Str::validBase64('VmFsaWQgYmFzZTY0IHRleH'));
    }
}
