<?php

namespace EmanueleCoppola\SmartWrap;

/**
 * A class for wrapping text into lines with a specified width,
 * supporting multibyte strings and optional word splitting.
 */
class SmartWrap
{

    /**
     * The computed lines after wrapping.
     *
     * @var string[] Array of strings, each representing a wrapped line.
     */
    private $lines = [];

    /**
     * A pointer to the last line in the $lines array.
     *
     * @var string Reference to the last line in the $lines array.
     */
    private $lastLine;

    /**
     * Resets the state of the class.
     * Initializes the $lines array and adds an initial empty line.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->lines = [];
        // Adds the first line.
        $this->addLine();
    }

    /**
     * Wraps the given text into lines of the specified width.
     *
     * Words are split based on spaces or optionally by force if they exceed
     * the width and $cut is set to true.
     *
     * @param string $text The input text to wrap.
     * @param int $width The maximum width of a line. Defaults to 75.
     * @param string $break The line break character(s). Defaults to "\n".
     * @param bool $cut Whether to force split words that are longer than $width. Defaults to false.
     *
     * @return string The wrapped text with lines separated by the $break character(s).
     */
    public function smartwrap(string $text, int $width = 75, string $break = "\n", bool $cut = false): string
    {
        $this->boot();

        $words₁ = $this->tokenizeText($text);

        foreach ($words₁ as $word₁) {
            $wordLength₁   = mb_strlen($word₁);
            $lastLineSpace = $width - mb_strlen($this->lastLine);

            // If the word fits the line spaces.
            if($lastLineSpace > $wordLength₁ || (($lastLineSpace == $width) && ($lastLineSpace == $wordLength₁))) {
                $this->addText($word₁);
            } else {
                // If the word is longer than the max line width.
                // Or if we should always cut it.
                if($wordLength₁ > $width || $cut) {
                    $start = $lastLineSpace == $width ? 0 : $lastLineSpace - 1;

                    $words₂ = $this->tokenizeWord($word₁, $width, $start);

                    foreach ($words₂ as $word₂) {
                        $wordLength₂   = mb_strlen($word₂);
                        $lastLineSpace = $width - mb_strlen($this->lastLine);

                        // If the word fits the line spaces.
                        if($lastLineSpace > $wordLength₂ || (($lastLineSpace == $width) && ($lastLineSpace == $wordLength₂))) {
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
     * Performs a multibyte-safe substring operation.
     *
     * @param string $string The input string.
     * @param int $start The starting position of the substring.
     * @param int|null $length The length of the substring. Defaults to null, extracting to the end.
     *
     * @return string The extracted substring.
     */
    public static function substr($string, $start, $length = null)
    {
        return mb_substr($string, $start, $length, 'UTF-8');
    }

    /**
     * Splits a text into an array of words based on spaces and newlines.
     *
     * @param string $text The input text to tokenize.
     *
     * @return string[] An array of words.
     */
    private function tokenizeText(string $text): array
    {
        return preg_split('/[\s\n]/', $text);
    }

    /**
     * Splits a word into smaller chunks of the specified width.
     *
     * @param string $word The input word to tokenize.
     * @param int $width The maximum width of each chunk.
     * @param int $start The starting position for tokenization. Defaults to 0.
     *
     * @return string[] An array of word chunks.
     */
    private function tokenizeWord(string $word, int $width, int $start = 0): array
    {
        $wordLength = mb_strlen($word);
        $words = [];

        // Index overflow or underflow checking.
        if($start < 0) $start = 0;
        if($start > $wordLength) $start = $wordLength;

        if($start && $start > 0) {
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
     * Adds a new line to the $lines array and updates the $lastLine pointer.
     *
     * @param string|null $text Optional text to initialize the new line. Defaults to an empty string.
     *
     * @return void
     */
    private function addLine(string $text = null): void
    {
        $this->lines[]  = $text ?: '';
        $this->lastLine = &$this->lines[count($this->lines) - 1];
    }

    /**
     * Appends text to the current line in the $lines array.
     *
     * @param string $text The text to append.
     *
     * @return void
     */
    private function addText(string $text): void
    {
        $this->lastLine .= (mb_strlen($this->lastLine) === 0 ? '' : ' ') . $text;
    }
}
