<?php

use EmanueleCoppola\SmartWrap\SmartWrap;

beforeEach(function () {
    $this->sw = new SmartWrap();
});

test('global smartwrap function is registered and working', function () {
    expect(function_exists('smartwrap'))->toBeTrue();

    $input = 'something to wrap';
    $expected = "something\nto wrap";

    $output = $this->sw->smartwrap($input, 10);

    expect($output)->toBe($expected);
});

test('boot empties lines each smartwrap call', function () {
    $input = 'something to wrap';
    $expected = "something\nto wrap";

    $this->sw->smartwrap($input, 10);
    $output = $this->sw->smartwrap($input, 10);

    expect($output)->toBe($expected);
});

test('break is considered', function () {
    $input = 'something to wrap';
    $expected = "something@to wrap";

    $output = $this->sw->smartwrap($input, 10, '@');

    expect($output)->toBe($expected);
});

test('smartwrap wraps lines correctly', function (array $testCase) {
    $output = $this->sw->smartwrap(
        $testCase['input'],
        $testCase['width'],
        $testCase['break'],
        $testCase['cut']
    );
    
    expect($output)->toBe($testCase['expected']);
})->with('smartwrap_test_data');
