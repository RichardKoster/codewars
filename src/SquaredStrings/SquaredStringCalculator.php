<?php

declare(strict_types=1);

namespace Richard\Codewars\SquaredStrings;

class SquaredStringCalculator
{
    public function oper(string $fct, $s)
    {
        return $this->$fct($s);
    }

    public function vertMirror($s)
    {
        return implode(PHP_EOL, array_map('strrev', preg_split("/(\r\n|\n|\r)/", $s)));
    }

    public function horMirror($s)
    {
        return implode(PHP_EOL, array_reverse(preg_split("/(\r\n|\n|\r)/", $s)));
    }
}
