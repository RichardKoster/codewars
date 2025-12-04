<?php

declare(strict_types=1);

namespace Richard\Codewars\MultiplicityComparison;

class MultiplicityComparison
{

    public function comp($a1, $a2)
    {
        if (null === $a1 || null === $a2) {
            return false;
        }

        return array_sum(array_map('floatval', $a1)) === array_sum(array_map('sqrt', $a2));
    }
}