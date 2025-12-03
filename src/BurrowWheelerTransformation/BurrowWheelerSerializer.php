<?php

declare(strict_types=1);

namespace Richard\Codewars\BurrowWheelerTransformation;

class BurrowWheelerSerializer {
    public function encode(string $s): array
    {
        $split = str_split($s);
        $matrix = [$split];
        for ($i = 0; $i < count($split) - 1; $i++) {
            array_unshift($split, array_pop($split));
            $matrix[] = $split;
        }

        usort($matrix, function ($a, $b) {return $b < $a ? 1 : -1;});

        return [
            implode('', array_column($matrix, \count($split)-1)),
            array_search(str_split($s), $matrix)
        ];
    }

    public function decode(string $s, int $i): string
    {
        if ('' === $s) {
            return '';
        }
        $lastCol = str_split($s);
        $firstCol = $lastCol;
        usort($firstCol, function ($a, $b) { return $b < $a ? 1 : -1; });

        $hashMap = array_combine(
            $this->orderedList($firstCol),
            $this->orderedList($lastCol)
        );

        $char = $hashMap[array_keys($hashMap)[$i]];
        $result = [substr($char, 0, 1)];
        while (\count($lastCol) > \count($result)) {
            $char = $hashMap[$char];
            $result[] = substr($char, 0, 1);
        }

        return implode('', array_reverse($result));
    }

    private function orderedList(array $list): array
    {
        $orderedList = [];
        for ($i = 0; $i < count($list); $i++) {
            $count = 1;
            while (in_array($list[$i].$count, $orderedList, true) !== false) {
                ++$count;
            }
            $orderedList[] = $list[$i].$count;
        }

        return $orderedList;
    }
}
