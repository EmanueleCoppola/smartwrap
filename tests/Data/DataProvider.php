<?php

namespace EmanueleCoppola\SmartWrap\Tests\Data;

class DataProvider
{

    public static function data()
    {
        /*
         * The first 5 parameters are the ones passed to wordwrap()/smartwrap() function.
         * The last 'swonly' is used to define if the test should pass only in smartwrap().
         */
        return [
            [
                [
                    'input'    => 'The Covid-19 is annoying',
                    'expected' => "The Covid-19\n" .
                                  "is annoying",
                    'width'    => 12,
                    'break'    => "\n",
                    'cut'      => false,
                    'swonly'   => false
                ]
            ],
            [
                [
                    'input'    => 'Также производит все типы жира и смазок и их побочных',
                    'expected' => "Также\n" .
                                  "производит\n" .
                                  "все типы\n" .
                                  "жира и\n" .
                                  "смазок и\n" .
                                  "их\n" .
                                  "побочных",
                    'width'    => 10,
                    'break'    => "\n",
                    'cut'      => false,
                    'swonly'   => true
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
                    'cut'      => true,
                    'swonly'   => true
                ]
            ],
            [
                [
                    'input'    => 'Availability of infrastructures',
                    'expected' => "Availability\n" .
                                  "of infrastru\n" .
                                  "ctures",
                    'width'    => 12,
                    'break'    => "\n",
                    'cut'      => true,
                    'swonly'   => true
                ]
            ],
            [
                [
                    'input'    => 'Cras cursus condimentumis ipsum quis facilis',
                    'expected' => "Cras cursus\n" .
                                  "condimentum\n" .
                                  "is ipsum qu\n" .
                                  "is facilis",
                    'width'    => 11,
                    'break'    => "\n",
                    'cut'      => true,
                    'swonly'   => true
                ]
            ],
            [
                [
                    'input'    => 'hello! heeeeeeeeeeeeeeereisaverylongword',
                    'expected' => "hello! heeeeeeeeeeee\n" .
                                  "eeereisaverylongword",
                    'width'    => 20,
                    'break'    => "\n",
                    'cut'      => true,
                    'swonly'   => true
                ]
            ],
            [
                [
                    'input'    => 'heeeeeeeeeeeeeeereisaverylongword',
                    'expected' => "heeeeeeeee\n" .
                                  "eeeeeereis\n" .
                                  "averylongw\n" .
                                  "ord",
                    'width'    => 10,
                    'break'    => "\n",
                    'cut'      => true,
                    'swonly'   => false
                ]
            ],
            [
                [
                    'input'    => 'heeeeeeeeeeeeeeereisaverylongword',
                    'expected' => "heeeeeeeee\n" .
                                  "eeeeeereis\n" .
                                  "averylongw\n" .
                                  "ord",
                    'width'    => 10,
                    'break'    => "\n",
                    'cut'      => false,
                    'swonly'   => true
                ]
            ]
        ];
    }

}