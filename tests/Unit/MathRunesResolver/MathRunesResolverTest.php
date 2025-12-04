<?php

declare(strict_types=1);

namespace Richard\Codewars\Unit\MathRunesResolver;

use PHPUnit\Framework\Attributes\CoversClass;
use Richard\Codewars\MathRunesResolver\MathRunesResolver;
use PHPUnit\Framework\TestCase;

#[CoversClass(MathRunesResolver::class)]
class MathRunesResolverTest extends TestCase
{
    public function testExamples()
    {
        $resolver = new MathRunesResolver();
        $this->assertSame(2, $resolver->solveExpression('1+1=?'));
        $this->assertSame(6, $resolver->solveExpression('123*45?=5?088'));
        $this->assertSame(0, $resolver->solveExpression('-5?*-1=5?'));
        $this->assertSame(-1, $resolver->solveExpression('19--45=5?'));
        $this->assertSame(5, $resolver->solveExpression('??*??=302?'));
        $this->assertSame(2, $resolver->solveExpression('?*11=??'));
        $this->assertSame(2, $resolver->solveExpression('??*1=??'));
        $this->assertSame(6, $resolver->solveExpression('-7715?5--484?00=-28?9?5'));
        $this->assertSame(0, $resolver->solveExpression('?+?=?'));
        $this->assertSame(0, $resolver->solveExpression('?-?=?'));
        $this->assertSame(0, $resolver->solveExpression('?*?=?'));
        $this->assertSame(-1, $resolver->solveExpression('??+?=?'));
        $this->assertSame(1, $resolver->solveExpression('??605*-63=-73???5'));
    }
}
