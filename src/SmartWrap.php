<?php

namespace EmanueleCoppola\SmartWrap;

class SmartWrap
{
    /**
     * Computed lines.
     *
     * @var string[] $lines
     */
    private $lines = [];

    /**
     * A pointer that points to the last line of $lines.
     *
     * @var string $lastLine
     */
    private $lastLine;

    /**
     * This function will be called everytime
     * the smartwrap() method is called.
     */
    public function boot()
    {
        $this->lines = [];
        // Adds the first line.
        $this->addLine();
    }

    /**
     * Smart wraps a text.
     *
     * @param string $text
     * @param int $width
     * @param string $break
     * @param bool $cut
     * @return string
     */
    public function smartwrap(string $text, int $width = 75, string $break = "\n", bool $cut = false)
    {
        $this->boot();

        $words₁ = $this->tokenizeText($text);

        foreach ($words₁ as $word₁) {
            $wordLength₁    = mb_strlen($word₁);
            $lastLineSpace = $width - mb_strlen($this->lastLine);

            // If the word fits the line spaces.
            if($lastLineSpace > $wordLength₁) {
                $this->addText($word₁);
            } else {
                // If the word is longer than the max line width.
                // Or if we should always cut it.
                if($wordLength₁ > $width || $cut) {
                    $words₂ = $this->tokenizeWord($word₁, $width, $lastLineSpace - 1);

                    foreach ($words₂ as $word₂) {
                        $wordLength₂   = mb_strlen($word₂);
                        $lastLineSpace = $width - mb_strlen($this->lastLine);

                        // If the word doesn't fit the line spaces.
                        if($lastLineSpace > $wordLength₂) {
                            $this->addText($word₂);
                        } else {
                            $this->addLine($word₂);
                        }
                    }
                } else {
                    $this->addLine($word₁);
                }
            }
        }

        return implode($break, $this->lines);
    }

    /**
     * Multibyte substr function.
     *
     * @param $string
     * @param $start
     * @param null $length
     * @return string
     */
    public static function substr($string, $start, $length = null)
    {
        return mb_substr($string, $start, $length, 'UTF-8');
    }

    /**
     * Function to tokenize a text into an array of words.
     *
     * @param string $text
     * @return string[]
     */
    private function tokenizeText(string $text)
    {
        return preg_split('/[\s\n]/', $text);
    }

    /**
     * Function to tokenize a word into an array of sub-tokens.
     *
     * @param string $word
     * @param int $width
     * @param int $start
     * @return string[]
     */
    private function tokenizeWord(string $word, int $width, int $start = 0)
    {
        $wordLength = mb_strlen($word);
        $words = [];

        // Index overflow or underflow checking.
        if($start < 0) $start = 0;
        if($start > $wordLength) $start = $wordLength;

        if($start) {
            $words[] = $this->substr($word, 0, $start);
            $word = $this->substr($word, $start, $wordLength);
        }

        // Frees up some memory.
        unset($wordLength);

        while (mb_strlen($word) > $width) {
            $words[] = $this->substr($word, 0, $width);
            $word = $this->substr($word, $width, mb_strlen($word));
        }

        if(mb_strlen($word) > 0) {
            $words[] = $word;
        }

        return $words;
    }

    /**
     * Pushes a new line to the $lines array and moves
     * the pointer to the last element of it.
     *
     * @param string|null $text
     */
    private function addLine(string $text = null)
    {
        $this->lines[]  = $text ?: '';
        $this->lastLine = &$this->lines[count($this->lines) - 1];
    }

    /**
     * Pushes some text to the last line.
     *
     * @param string|null $text
     */
    private function addText(string $text)
    {
        $this->lastLine .= (mb_strlen($this->lastLine) === 0 ? '' : ' ') . $text;
    }

}