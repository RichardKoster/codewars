<?php

namespace Richard\Codewars\Befunge93;

class Befunge93Runner {
    private const DIRECTION_MAP = [
        '<' => 1,
        '>' => 2,
        '^' => 3,
        'v' => 4
    ];

    private Map $map;
    private int $direction = 2;
    private array $coordinates = [];
    private array $stack = [];
    private string $output = '';
    private bool $shouldIgnoreNext = false;
    private array $unprocessed = [];

    public function __construct(string $code)
    {
        $this->map = Map::codeToMap($code);
    }

    public function run(): void
    {
        $this->step();
    }

    private function step(): void
    {
        [$x, $y] = $this->calculateNewCoordinates();

        $this->coordinates = [$x, $y];
        $value = $this->map->getCoordinateValue(...$this->coordinates);
        if ('@' === $value) {
            return;
        }

        $this->processValue($value);

        $this->step();
    }

    private function calculateNewCoordinates(): array
    {
        if ([] === $this->coordinates) {
            return [0,0];
        }

        [$x, $y] = $this->coordinates;

        return match ($this->direction) {
            default =>  [$x - 1, $y],
            2 => [$x + 1, $y],
            3 => [$x, $y - 1],
            4 => [$x, $y + 1],
        };
    }

    public function getOutput(): string
    {
        return $this->output;
    }

    private function processValue(string $value): void
    {
        if ($this->shouldIgnoreNext) {
            $this->shouldIgnoreNext = false;

            return;
        }

        match (true) {
            default => $this->unprocessed[] = $value,
            str_contains('<>^v', $value) =>  $this->direction = self::DIRECTION_MAP[$value],
            str_contains('0123456789', $value) =>  $this->stack[] = (int) $value,
            $value === '.' => $this->popAndAppendOutput(),
            $value === ',' => $this->popAndAppendChrToOutput(),
            $value === ':' => $this->copyLastStackValue(),
            $value === '$' => array_pop($this->stack),
            $value === '\\' => $this->swapTopStackEntries(),
            $value === '_' => $this->popAndDirectHorizontal(),
            $value === '|' => $this->popAndDirectVertical(),
            str_contains('*/-+', $value) => $this->calculateTopEntries($value),
            $value === '"' => $this->addStringOrdToStack(),
            $value === '#' => $this->shouldIgnoreNext = true,
            $value === 'g' => $this->get(),
            $value === 'p' => $this->put(),
            $value === '!' => $this->not(),
            $value === '`' => $this->greaterThan(),
            $value === '?' => $this->setRandomDirection(),
        };
    }

    private function popAndAppendOutput(): void
    {
        $this->output .= array_pop($this->stack);
    }

    private function popAndAppendChrToOutput(): void
    {
        $this->output .= chr(array_pop($this->stack));
    }

    private function copyLastStackValue(): void
    {
        $end = end($this->stack);

        $this->stack[] = $end !== false ? $end : 0;
    }

    private function swapTopStackEntries(): void
    {
        $lastValue = array_pop($this->stack);
        $valueBefore = array_pop($this->stack);
        $this->stack[] = $lastValue;
        $this->stack[] = $valueBefore;
    }

    private function popAndDirectHorizontal(): void
    {
        $value = array_pop($this->stack);

        $this->direction = $value !== 0 ? self::DIRECTION_MAP['<'] : self::DIRECTION_MAP['>'];
    }

    private function popAndDirectVertical(): void
    {
        $value = array_pop($this->stack);

        $this->direction = $value !== 0 ? self::DIRECTION_MAP['^'] : self::DIRECTION_MAP['v'];
    }

    private function calculateTopEntries(string $value): void
    {
        $lastValue = array_pop($this->stack);
        $valueBefore = array_pop($this->stack);
        $this->stack[] = match($value) {
            default => $lastValue + $valueBefore,
            '-' => $valueBefore - $lastValue,
            '*' => $lastValue * $valueBefore,
            '/' => $valueBefore / $lastValue,
        };
    }

    private function addStringOrdToStack(): void
    {
        [$x, $y] = $this->calculateNewCoordinates();
        $this->coordinates = [$x, $y];
        $newValue = $this->map->getCoordinateValue($x, $y);
        while ($newValue !== '"') {
            $this->stack[] = ord($newValue);
            [$x, $y] = $this->calculateNewCoordinates();
            $newValue = $this->map->getCoordinateValue($x, $y);
            $this->coordinates = [$x, $y];
        }
    }

    private function get(): void
    {
        $y = array_pop($this->stack);
        $x = array_pop($this->stack);
        $this->stack[] = ord($this->map->getCoordinateValue($x, $y));
    }

    private function put(): void
    {
        $y = array_pop($this->stack);
        $x = array_pop($this->stack);
        $v = array_pop($this->stack);

        $this->map->setCoordinateValue($x, $y, chr($v));
    }

    private function not(): void
    {
        $value = array_pop($this->stack);

        $this->stack[] = $value === 0 ? 1 : 0;
    }

    private function greaterThan(): void
    {
        $a = array_pop($this->stack);
        $b = array_pop($this->stack);

        $this->stack[] = $b > $a ? 1 : 0;
    }

    private function setRandomDirection(): void
    {
        $this->direction = random_int(1, 4);
    }
}