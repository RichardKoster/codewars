<?php

declare(strict_types=1);

namespace Richard\Codewars\MathExpressionEvaluator;

class MathExpressionEvaluator
{
    public function calc(string $expression): float
    {
        $expression = $this->handleParentheses($expression);

        return $this->handleArithmetics($expression);
    }

    private function handleParentheses(string $expression): string
    {
        if (!preg_match('/\(|\)/', $expression)) {
            return $expression;
        }

        return preg_replace_callback('/\((?:[^()]|(?R))*\)/', function ($matches) {
            $innerExpression = trim($matches[0], '()');
            if (preg_match('/\(|\)/', $innerExpression)) {
                return $this->handleParentheses($innerExpression);
            }

            return $this->handleArithmetics($innerExpression);
        }, $expression);
    }

    private function handleArithmetics(string $expression): float
    {
        preg_match_all('/-?\d*\.?\d+|[+\/*-]/', $expression, $matches);

        $matches = $matches[0];

        // Handle product and division first
        while ([false, false] !== [array_search('*', $matches), array_search('/', $matches)]) {
            $productPos = array_search('*', $matches) ?: INF;
            $divisionPos = array_search('/', $matches) ?: INF;
            $first = min($productPos, $divisionPos);
            $a = (float) $matches[$first - 1];
            $operator = $matches[$first];
            $b = (float)  $matches[$first + 1];
            $result = $operator === '*' ? $a * $b : $a / $b;
            $matches[$first] = $result;
            unset($matches[$first - 1], $matches[$first + 1]);
            $matches = array_values($matches);
        }

        while ([false, false] !== [array_search('+', $matches), array_search('-', $matches)]) {
            $sumPos = array_search('+', $matches) ?: INF;
            $differencePos = array_search('-', $matches) ?: INF;
            $first = min($sumPos, $differencePos);
            $a = (float) $matches[$first - 1];
            $operator = $matches[$first];
            $b = (float)  $matches[$first + 1];
            $result = $operator === '+' ? $a + $b : $a - $b;
            $matches[$first] = $result;
            unset($matches[$first - 1], $matches[$first + 1]);
            $matches = array_values($matches);
        }

        return (float) reset($matches);
    }
}
