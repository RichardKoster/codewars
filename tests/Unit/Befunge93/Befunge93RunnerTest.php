<?php

declare(strict_types=1);

namespace Richard\Codewars\Unit\Befunge93;

use PHPUnit\Framework\Attributes\CoversClass;
use Richard\Codewars\Befunge93\Befunge93Runner;
use PHPUnit\Framework\TestCase;
use Richard\Codewars\Befunge93\Map;

#[CoversClass(Befunge93Runner::class)]
#[CoversClass(Map::class)]
class Befunge93RunnerTest extends TestCase
{
    private string $example1 = <<<TEXT
>987v>.v
v456<  :
>321 ^ _@
TEXT;

    private string $example2 = <<<TEXT
>25*"!dlroW olleH":v
                v:,_@
                >  ^
TEXT;

    private string $example3 = <<<TEXT
08>:1-:v v *_$.@ 
  ^    _$>\:^
TEXT;

    private string $example4 = <<<TEXT
01->1# +# :# 0# g# ,# :# 5# 8# *# 4# +# -# _@
TEXT;

    private string $example5 = <<<TEXT
2>:3g" "-!v\  g30          <
 |!`"&":+1_:.:03p>03g+:"&"`|
 @               ^  p3\" ":<
2 2345678901234567890123456789012345678
TEXT;

    public function testRunExample1()
    {
        $runner = new Befunge93Runner($this->example1);

        $runner->run();

        self::assertSame('123456789', $runner->getOutput());
    }

    public function testRunExample2(): void
    {
        $runner = new Befunge93Runner($this->example2);

        $runner->run();

        self::assertSame('Hello World!'.PHP_EOL, $runner->getOutput());
    }

    public function testRunExample3(): void
    {
        $runner = new Befunge93Runner($this->example3);

        $runner->run();
        self::assertSame('40320', $runner->getOutput());
    }

    public function testRunExample4(): void
    {
        $runner = new Befunge93Runner($this->example4);
        $runner->run();
        self::assertSame('01->1# +# :# 0# g# ,# :# 5# 8# *# 4# +# -# _@', $runner->getOutput());
    }
    public function testRunExample5(): void
    {
        $runner = new Befunge93Runner($this->example5);
        $runner->run();
        self::assertSame('23571113171923293137', $runner->getOutput());
    }
}
