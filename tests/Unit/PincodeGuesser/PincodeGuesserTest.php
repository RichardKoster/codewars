<?php

declare(strict_types=1);

namespace Richard\Codewars\Unit\PincodeGuesser;

use PHPUnit\Framework\Attributes\CoversClass;
use Richard\Codewars\PincodeGuesser\PincodeGuesser;
use PHPUnit\Framework\TestCase;

#[CoversClass(PincodeGuesser::class)]
class PincodeGuesserTest extends TestCase
{
    public function testGetPins()
    {
        $guesser = new PincodeGuesser();
        $expectations = [
//            "8" => ["5", "7", "8", "9", "0"],
//            "11" => ["11", "22", "44", "12", "21", "14", "41", "24", "42"],
//            "369" => ["339","366","399","658","636","258","268","669","668","266","369","398","256","296","259","368","638","396","238","356","659","639","666","359","336","299","338","696","269","358","656","698","699","298","236","239"],
            "007" => ['004','007','008','084','087','088','804','807','808','884','887','888']
        ];
        foreach ($expectations as $pin => $expect) {
            $actual = $guesser->getPINs($pin);
            sort($actual);
            sort($expect);
            $this->assertSame($expect, $actual);
        }
    }
}
