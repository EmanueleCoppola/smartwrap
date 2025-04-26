<?php

test('SmartWrap wraps lines correctly and checks if it provides any additional value over PHP wordwrap', function ($test) {
    $input    = $test['input'];
    $expected = $test['expected'];
    $width    = $test['width'];
    $break    = $test['break'];
    $cut      = $test['cut'];
    $swonly   = $test['swonly'];

    $output = wordwrap($input, $width, $break, $cut);

    if ($swonly) {
        expect($output)->not->toBe($expected); // If swonly is set, it should differ
    } else {
        expect($output)->toBe($expected); // Otherwise, it should match the expected output
    }
})->with('smartwrap_test_data');
