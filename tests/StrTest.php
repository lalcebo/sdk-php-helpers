<?php

/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

use Lalcebo\Helpers\Str;

beforeEach(function () {
    $this->providedTestString = 'Neque porro quisquam est qui dolorem ipsum quia dolor sit...';
    $this->url = 'https://github.com/lalcebo';
    $this->urlBase64Encode = 'aHR0cHM6Ly9naXRodWIuY29tL2xhbGNlYm8';
});

it('should contains a simple value', function ($value, $match) {
    expect(Str::contains($value, $this->providedTestString))->toEqual($match);
})->with([
    ['ipsum', true], ['Dolor', false],
]);

it('should contains array values', function ($value, $match) {
    expect(Str::contains($value, $this->providedTestString))->toEqual($match);
})->with([
    [['porro', 'ipsum'], true],
    [['unknown', 'hello'], false],
]);

it('should contains all values', function ($value, $match) {
    expect(Str::containsAll($value, $this->providedTestString))->toEqual($match);
})->with([
    [['Neque', 'ipsum'], true],
    [['quisquam', 'Hello'], false],
]);

it('should contains insensitive simple value', function ($value, $match) {
    expect(Str::containsInsensitive($value, $this->providedTestString))->toEqual($match);
})->with([
    ['neque', true],
    ['falseWord', false],
]);

it('should contains insensitive array values', function ($value, $match) {
    expect(Str::containsInsensitive($value, $this->providedTestString))->toEqual($match);
})->with([
    [['neque', 'Ipsum'], true],
    [['Unknown', 'Hello'], false],
]);

it('should contains all insensitive array values', function ($value, $match) {
    expect(Str::containsAllInsensitive($value, $this->providedTestString))->toEqual($match);
})->with([
    [['neque', 'Ipsum'], true],
    [['quisquam', 'Hello'], false],
]);

it('should encode url to base64 ', function () {
    expect(Str::urlBase64Encode($this->url))
        ->toEqual($this->urlBase64Encode);
});

it('should decode url from base64', function () {
    expect(Str::urlBase64Decode($this->urlBase64Encode))
        ->toEqual($this->url);
});

it('should check a valid base64', function ($value, $match) {
    expect(Str::validBase64($value))
        ->toEqual($match);
})->with([
    ['VmFsaWQgYmFzZTY0IHRleHQ=', true],
    ['falseBase64String', false],
    ['$&^#invalidBase64String', false],
    ['VmFsaWQgYmFzZTY0IHRleH', false],
]);
