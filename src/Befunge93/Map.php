<?php

declare(strict_types=1);

namespace Richard\Codewars\Befunge93;

class Map
{
    private function __construct(private array $map) {}

    public static function codeToMap(string $code): self
    {
        $lines = preg_split("/(\r\n|\n|\r)/",$code);

        return new self(array_map('str_split', $lines));
    }

    public function getMap(): array
    {
        return $this->map;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function getCoordinateValue(int $x, int $y): string
    {
        $value = $this->map[$y][$x] ?? null;
        if (null === $value) {
            throw new \InvalidArgumentException(sprintf('No value for x(%d) and y(%d)', $x, $y));
        }

        return $value;
    }

    public function setCoordinateValue(int $x, int $y, string $value): void
    {
        $this->map[$y][$x] = $value;
    }
}