<?php

declare(strict_types=1);

namespace Richard\Codewars\Unit\MultiplicityComparison;

use PHPUnit\Framework\Attributes\CoversClass;
use Richard\Codewars\MultiplicityComparison\MultiplicityComparison;
use PHPUnit\Framework\TestCase;

#[CoversClass(MultiplicityComparison::class)]
class MultiplicityComparisonTest extends TestCase
{
    protected function setUp(): void
    {
        $this->comparison = new MultiplicityComparison();
    }

    private function revTest($actual, $expected) {
        $this->assertSame($expected, $actual);
    }
    public function testBasics() {
        $a1 = [121, 144, 19, 161, 19, 144, 19, 11];
        $a2 = [11*11, 121*121, 144*144, 19*19, 161*161, 19*19, 144*144, 19*19];
        $this->revTest($this->comparison->comp($a1, $a2), true);
        $a1 = [121, 144, 19, 161, 19, 144, 19, 11];
        $a2 = [11*21, 121*121, 144*144, 19*19, 161*161, 19*19, 144*144, 19*19];
        $this->revTest($this->comparison->comp($a1, $a2), false);

        $a1 = [121, 144, 19, 161, 19, 144, 19, 11];
        $a2 = [121, 14641, 20736, 36100, 25921, 361, 20736, 361];
        $this->revTest($this->comparison->comp($a1, $a2), false);

        $this->revTest($this->comparison->comp(null, null), false);
        $this->revTest($this->comparison->comp($a1, null), false);
        $this->revTest($this->comparison->comp(null, $a2), false);

        $a = [81, 59, 19, 33, 79, 34, 58, 76, 77, 96, 48];
        $b = [6562, 3481, 361, 1089, 6241, 1156, 3364, 5776, 5929, 9216, 2304];
        $this->revTest($this->comparison->comp($a, $b), false);
    }
}
