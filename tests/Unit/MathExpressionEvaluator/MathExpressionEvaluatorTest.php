<?php

declare(strict_types=1);

namespace Richard\Codewars\Unit\MathExpressionEvaluator;

use PHPUnit\Framework\Attributes\CoversClass;
use Richard\Codewars\MathExpressionEvaluator\MathExpressionEvaluator;
use PHPUnit\Framework\TestCase;

#[CoversClass(MathExpressionEvaluator::class)]
class MathExpressionEvaluatorTest extends TestCase
{
    protected function randomize(array $a): array {
        for ($i = 0; $i < 2 * count($a); $i++) list($a[$j], $a[$k]) = [$a[$k = array_rand($a)], $a[$j = array_rand($a)]];
        return $a;
    }
    public function testShuffledExamples() {
        $evaluator = new MathExpressionEvaluator();
        foreach ([
            ['1+1', 2.0],
            ['1 - 1', 0.0],
            ['1* 1', 1.0],
            ['1 /1', 1.0],
            ['-123', -123.0],
            ['123', 123.0],
            ['2 /2+3 * 4.75- -6', 21.25],
            ['12* 123', 1476.0],
            ['2 / (2 + 3) * 4.33 - -6', 7.732],
        ] as $a) $this->assertSame($a[1], floatval($evaluator->calc($a[0])));
    }
}
