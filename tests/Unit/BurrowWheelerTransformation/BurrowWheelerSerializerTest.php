<?php

declare(strict_types=1);

namespace Richard\Codewars\Unit\BurrowWheelerTransformation;

use PHPUnit\Framework\Attributes\CoversClass;
use Richard\Codewars\BurrowWheelerTransformation\BurrowWheelerSerializer;
use PHPUnit\Framework\TestCase;

#[CoversClass(BurrowWheelerSerializer::class)]
class BurrowWheelerSerializerTest extends TestCase
{
    public function testEncode()
    {
        $serializer = new BurrowWheelerSerializer();
        $this->assertSame(["nnbbraaaa", 4],     $serializer->encode("bananabar"));
        $this->assertSame(["e emnllbduuHB", 2], $serializer->encode("Humble Bundle"));
        $this->assertSame(["ww MYeelllloo", 1], $serializer->encode("Mellow Yellow"));
    }
    public function testDecodeFunction()
    {
        $serializer = new BurrowWheelerSerializer();
        $this->assertSame("",     $serializer->decode("", -1));
        $this->assertSame("bananabar",     $serializer->decode("nnbbraaaa", 4));
        $this->assertSame("Humble Bundle", $serializer->decode("e emnllbduuHB", 2));
        $this->assertSame("Mellow Yellow", $serializer->decode("ww MYeelllloo", 1));
        $this->assertSame("bxieCgRjJLcu+qM426P70Imndw==", $serializer->decode("u74M2Pw=e0jJq6g=LniCxRIm+cdb", 15));
    }
}
