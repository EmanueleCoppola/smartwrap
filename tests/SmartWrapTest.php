<?php

namespace EmanueleCoppola\SmartWrap\Tests;

use PHPUnit\Framework\TestCase;
use EmanueleCoppola\SmartWrap\SmartWrap;
use EmanueleCoppola\SmartWrap\Tests\Data\DataProvider;

class SmartWrapTest extends TestCase
{
    /**
     * SmartWrap instance.
     *
     * @var $sw SmartWrap
     */
    private $sw;

    /**
     * @inheritDoc
     */
    function setUp(): void
    {
        $this->sw = new SmartWrap();
    }

    function test_global_smartwrap_function_is_registered_and_working()
    {
        $this->assertTrue(function_exists('smartwrap'));

        $input    = 'something to wrap';
        $expected = "something\nto wrap";

        $output = $this->sw->smartwrap($input, 10);

        $this->assertEquals($expected, $output);
    }

    function test_boot_empties_lines_each_smartwrap_call()
    {
        $input    = 'something to wrap';
        $expected = "something\nto wrap";

        $this->sw->smartwrap($input, 10);
        $output = $this->sw->smartwrap($input, 10);

        $this->assertEquals($expected, $output);
    }

    function test_break_is_considered()
    {
        $input    = 'something to wrap';
        $expected = "something@to wrap";

        $output = $this->sw->smartwrap($input, 10, '@');

        $this->assertEquals($expected, $output);
    }

    /** @dataProvider  smartwrap_test_data() */
    function test_smartwrap_wraps_lines_correctly($test)
    {
        $input    = $test['input'];
        $expected = $test['expected'];
        $width    = $test['width'];
        $break    = $test['break'];
        $cut      = $test['cut'];

        $output = $this->sw->smartwrap($input, $width, $break, $cut);

        $this->assertEquals($expected, $output);
    }

    function smartwrap_test_data()
    {
        return DataProvider::data();
    }
}
