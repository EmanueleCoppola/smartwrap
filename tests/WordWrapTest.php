<?php

namespace EmanueleCoppola\SmartWrap\Tests;

use PHPUnit\Framework\TestCase;
use EmanueleCoppola\SmartWrap\Tests\Data\DataProvider;

class WordWrapTest extends TestCase
{
    /** @dataProvider  wordwrap_test_data() */
    function test_wordwrap_wraps_lines_incorrectly($test)
    {
        $input    = $test['input'];
        $expected = $test['expected'];
        $width    = $test['width'];
        $break    = $test['break'];
        $cut      = $test['cut'];
        $swonly   = $test['swonly'];

        $output = wordwrap($input, $width, $break, $cut);

        if($swonly)
            $this->assertNotEquals($expected, $output);
        else
            $this->assertEquals($expected, $output);
    }

    function wordwrap_test_data()
    {
        return DataProvider::data();
    }
}
