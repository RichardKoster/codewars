<?php

declare(strict_types=1);

namespace Richard\Codewars\Unit\Befunge93;

use PHPUnit\Framework\Attributes\CoversClass;
use Richard\Codewars\Befunge93\Map;
use PHPUnit\Framework\TestCase;

#[CoversClass(Map::class)]
class MapTest extends TestCase
{
    private string $example1 = <<<TEXT
>987v>.v
v456<  :
>321 ^ _@
TEXT;
    public function testCodeToMap(): void
    {
        $map = Map::codeToMap($this->example1);

        $lines = preg_split("/(\r\n|\n|\r)/", $this->example1);
        $expected = array_map('str_split', $lines);

        self::assertSame($expected, $map->getMap());
    }

    public function testGetCoordinateValue(): void
    {
        $map = Map::codeToMap($this->example1);

        self::assertSame('>', $map->getCoordinateValue(0, 0));
        self::assertSame('v', $map->getCoordinateValue(0, 1));
        self::assertSame('9', $map->getCoordinateValue(1, 0));
    }

    public function testExceptionForOutOfBoundsQuery(): void
    {
        $map = Map::codeToMap($this->example1);

        $this->expectException(\InvalidArgumentException::class);
        self::assertSame('9', $map->getCoordinateValue(1337, 0));
    }
}
