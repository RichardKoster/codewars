<?php

declare(strict_types=1);

namespace Richard\Codewars\Unit\VigenereCipher;

use PHPUnit\Framework\Attributes\CoversClass;
use Richard\Codewars\VigenereCipher\VigenereCipher;
use PHPUnit\Framework\TestCase;

#[CoversClass(VigenereCipher::class)]
class VigenereCipherTest extends TestCase
{
    public function test1() {
        $c = new VigenereCipher('password', 'abcdefghijklmnopqrstuvwxyz');

        $this->assertSame('rovwsoiv', $c->encode('codewars'));
        $this->assertSame('codewars', $c->decode('rovwsoiv'));

        $this->assertSame('laxxhsj', $c->encode('waffles'));
        $this->assertSame('waffles', $c->decode('laxxhsj'));

        $this->assertSame('CODEWARS', $c->encode('CODEWARS'));
        $this->assertSame('CODEWARS', $c->decode('CODEWARS'));

    }
}
