<?php

declare(strict_types=1);

namespace Richard\Codewars\Unit\SquaredStrings;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use Richard\Codewars\SquaredStrings\SquaredStringCalculator;
#[CoversClass(SquaredStringCalculator::class)]
class SquaredStringCalculatorTest extends TestCase
{
    private SquaredStringCalculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new SquaredStringCalculator();
    }

    private function revTest($actual, $expected) {
        $this->assertSame($expected, $actual);
    }
    public function testOperVerticalBasics() {
        $this->revTest($this->calculator->oper('vertMirror', "hSgdHQ\nHnDMao\nClNNxX\niRvxxH\nbqTVvA\nwvSyRu"), "QHdgSh\noaMDnH\nXxNNlC\nHxxvRi\nAvVTqb\nuRySvw");
        $this->revTest($this->calculator->oper('vertMirror', "IzOTWE\nkkbeCM\nWuzZxM\nvDddJw\njiJyHF\nPVHfSx"), "EWTOzI\nMCebkk\nMxZzuW\nwJddDv\nFHyJij\nxSfHVP");
    }
    public function testOperHorizontalBasics() {
        $this->revTest($this->calculator->oper('horMirror', "lVHt\nJVhv\nCSbg\nyeCt"), "yeCt\nCSbg\nJVhv\nlVHt");
        $this->revTest($this->calculator->oper('horMirror', "njMK\ndbrZ\nLPKo\ncEYz"), "cEYz\nLPKo\ndbrZ\nnjMK");
    }
}