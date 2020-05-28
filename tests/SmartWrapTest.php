<?php

namespace EmanueleCoppola\SmartWrap\Tests;

use PHPUnit\Framework\TestCase;
use EmanueleCoppola\SmartWrap\SmartWrap;

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

    function test_boot_empties_lines_each_smartwrap_call()
    {
        $input    = 'something to wrap';
        $expected = "something\n" .
                    "to wrap";

        $this->sw->smartwrap($input, 10);
        $output = $this->sw->smartwrap($input, 10);

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
        return [
            [
                [
                    'input'    => 'The Covid-19 is annoying',
                    'expected' => "The Covid-19\n" .
                                  "is annoying",
                    'width'    => 12,
                    'break'    => "\n",
                    'cut'      => false
                ]
            ],
            [
                [
                    'input'    => 'The coronavirus is spread all over the world',
                    'expected' => "The coronavi\n" .
                                  "rus is sprea\n" .
                                  "d all over t\n" .
                                  "he world",
                    'width'    => 12,
                    'break'    => "\n",
                    'cut'      => true
                ]
            ]
        ];
    }
}
