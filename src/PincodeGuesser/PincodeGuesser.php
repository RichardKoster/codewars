<?php

declare(strict_types=1);

namespace Richard\Codewars\PincodeGuesser;

class PincodeGuesser
{
    private array $keypad = [
        ['1', '2', '3'],
        ['4', '5', '6'],
        ['7', '8', '9'],
        [null, '0', null]
    ];

    public function getPins($observed): array
    {
        $observed = (string)$observed;
        $count = strlen($observed);

        $indexNeighborsMap = [];
        for ($i = 0; $i < $count; $i++) {
            $indexNeighborsMap[$i] = $this->calculateNeighbors($observed[$i]);
        }

        return $this->doResolve($indexNeighborsMap);
    }

    public function doResolve($neighborMap, int $index = 0): array
    {
        $values = $neighborMap[$index];
        if (array_key_exists($index + 1, $neighborMap)) {
            $nextCharOptions = $this->doResolve($neighborMap, $index + 1);
            $interimValues = [];
            foreach ($values as $digit) {

                foreach ($nextCharOptions as $nextCharOption) {
                    $interimValues[] = $digit . $nextCharOption;
                }
            }

            return $interimValues;
        }

        return $values;
    }

    private function calculateNeighbors(string $observed): array
    {
        $keyPadRowPressedIndex = array_find($this->keypad, fn($row) => in_array($observed, $row));
        if (false === $keyPadRowPressedIndex) {
            throw new \LogicException('Button pressed not found in keypad');
        }
        $keyPadRowColumnIndex = array_search($observed, $this->keypad[$keyPadRowPressedIndex], true);

        return array_filter([
            $this->keypad[$keyPadRowPressedIndex - 1][$keyPadRowColumnIndex] ?? null, // Above
            $this->keypad[$keyPadRowPressedIndex][$keyPadRowColumnIndex - 1] ?? null, // To Left of
            $this->keypad[$keyPadRowPressedIndex][$keyPadRowColumnIndex] ?? null, // Observed button pressed
            $this->keypad[$keyPadRowPressedIndex][$keyPadRowColumnIndex + 1] ?? null, // To Right of
            $this->keypad[$keyPadRowPressedIndex + 1][$keyPadRowColumnIndex] ?? null, // Below
        ], fn($pin) => $pin !== null);
    }
}

function array_find(array $haystack, callable $callback): int|false {
    foreach ($haystack as $key => $value) {
        if ($callback($value, $key, $haystack)) {
            return $key;
        }
    }
    return false;
}