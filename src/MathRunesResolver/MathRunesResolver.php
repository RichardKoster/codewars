<?php

declare(strict_types=1);

namespace Richard\Codewars\MathRunesResolver;

class MathRunesResolver
{
    public function solveExpression(string $expression): int
    {
        $expressionRegex = '/(?<a>\-?[0-9\?]+)(?<opr>[\+\-\*])(?<b>\-?[0-9\?]+)=(?<res>\-?[0-9\?]+)/';
        preg_match($expressionRegex, $expression, $matches);
        $a = $matches['a'] ?? null;
        $b = $matches['b'] ?? null;
        $opr = $matches['opr'] ?? null;
        $res = $matches['res'] ?? null;
        if ($a === null || $b === null || $opr === null || $res === null) {
            return -1;
        }
        $candidates = range(0, 9);
        preg_match_all('/\d/', $expression, $numbers);
        $numbers = array_unique($numbers[0]);
        $availableNumbers = array_diff($candidates, $numbers);
        $values = [$a, $b, $res];
        foreach ($values as $value) {
            if (str_starts_with((string) $value, '?') && strlen((string) $value) > 1) {
                unset($availableNumbers[array_search(0, $availableNumbers, true)]);
                break;
            }
        }

        foreach ($availableNumbers as $number) {
            [$resolvedA, $resolvedB, $resolvedResult] = array_map(fn ($value) => str_replace('?', (string) $number, (string) $value), [$a, $b, $res]);
            $calculation = match($opr) {
                default => (int) $resolvedA + (int)$resolvedB,
                '*' => (int) $resolvedA * (int) $resolvedB,
                '-' => (int) $resolvedA - (int) $resolvedB,
            };

            if ($resolvedResult === (string) $calculation) {
                return $number;
            }
        }

        return -1;
    }
}