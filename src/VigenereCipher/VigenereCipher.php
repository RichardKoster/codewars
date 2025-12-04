<?php

declare(strict_types=1);

namespace Richard\Codewars\VigenereCipher;

class VigenereCipher
{
    private int $keyLength;
    private int $alphabetLength;

    public function __construct(private string $key, private string $alphabet)
    {
        $this->keyLength = strlen($this->key);
        $this->alphabetLength = strlen($this->alphabet);
    }

    public function encode($s) {
        $encodedString = '';
        for ($i = 0; $i < strlen($s); $i++) {
            if (false === $charPosition = strpos($this->alphabet, $s[$i])) {
                $encodedString .= $s[$i];
                continue;
            }

            $increment = strpos($this->alphabet, $this->key[$i % $this->keyLength]);
            $encodedString .= $this->alphabet[($charPosition + $increment) % $this->alphabetLength];
        }

        return $encodedString;
    }

    public function decode($s) {
        $decodedString = '';
        for ($i = 0; $i < strlen($s); $i++) {
            if (false === $charPosition = strpos($this->alphabet, $s[$i])) {
                $decodedString .= $s[$i];
                continue;
            }

            $decrement = strpos($this->alphabet, $this->key[$i % $this->keyLength]);
            $decodedString .= $this->alphabet[($charPosition - $decrement) % $this->alphabetLength];
        }

        return $decodedString;
    }
}