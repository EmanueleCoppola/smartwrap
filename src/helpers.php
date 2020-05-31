<?php

if(!function_exists('smartwrap')) {
    function smartwrap(string $text, int $width = 75, string $break = "\n", bool $cut = false) {
        $sw = new EmanueleCoppola\SmartWrap\SmartWrap();
        $result = $sw->smartwrap($text, $width, $break, $cut);
        unset($sw);
        return $result;
    }
}
