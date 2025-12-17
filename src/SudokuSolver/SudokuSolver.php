<?php

declare(strict_types=1);

namespace Richard\Codewars\SudokuSolver;

class SudokuSolver
{
    private array $candidatesMap = [];
    private array $sudokuRange = [1,2,3,4,5,6,7,8,9];
    public function __construct(private array $board)
    {
        $this->buildCandidatesMap($board);
    }

    /**
     * Build a map of for each cell that is 0 with each number it can hold, for sudoku a range of 1-9.
     */
    private function buildCandidatesMap(array $board): void
    {
        foreach ($board as $y => $row) {
            foreach ($row as $x => $cell) {
                if ($cell !== 0) continue;

                $this->candidatesMap[$y][$x] = array_combine($this->sudokuRange, $this->sudokuRange);
            }
        }
    }

    /**
     * Start the solve process for the board that was set in the constructor.
     */
    function solve(): array
    {
        $count = 0;
        while (!$this->isSolved() && $count <= 10) {
            $this->doSolve();
            $count++;
        }

        return $this->board;
    }

    /**
     * Iterate through the cells on the sudoku board and remove candidates from the map created by the buildCandidatesMap() method
     */
    private function doSolve(): void
    {
        foreach ($this->board as $y => $row) {
            foreach ($row as $x => $cell) {
                if ($this->board[$y][$x] !== 0) continue;

                $this->removeGroupCandidates($y, $x);
                $this->removeRowCandidates($y, $x);
                $this->removeColumnCandidates($y, $x);
            }
        }
    }

    /**
     * Checker if the board has been solved, checks if no rows hold a 0 value anywhere
     */
    private function isSolved(): bool
    {
        $unresolvedRows = array_filter($this->board, function(array $row) {
            $zeroValues = array_count_values($row)[0] ?? null;

            return null !== $zeroValues;
        });

        return 0 === count($unresolvedRows);
    }

    /**
     * In a group of 3x3 cells, remove candidates that are already present in the group.
     */
    private function removeGroupCandidates(int $y, int $x): void
    {
        if (null === ($this->candidatesMap[$y][$x] ?? null)) {
            return;
        }

        $coordinates = $this->getCellGroup($y, $x);

        foreach ($coordinates as [$xPos, $yPos]) {
            $value = $this->board[$yPos][$xPos];
            if ($value !== 0) {
                unset($this->candidatesMap[$y][$x][$value]);
            }
        }

        $this->checkValue($y, $x);
    }

    /**
     * For a cell, remove all candidates that are present in the same row.
     */
    private function removeRowCandidates(int $y, int $x): void
    {
        if (null === ($this->candidatesMap[$y][$x] ?? null)) {
            return;
        }

        $this->removeLineCandidates($this->board[$y], $x, $y);

        $this->checkValue($y, $x);
    }

    /**
     * For a cell, remove all candidates that are present in the same row.
     */
    private function removeColumnCandidates(int $y, int $x): void
    {
        if (null === ($this->candidatesMap[$y][$x] ?? null)) {
            return;
        }

        $this->removeLineCandidates(array_column($this->board, $x), $x, $y);

        $this->checkValue($y, $x);
    }

    /**
     * For a line (row or column), remove all candidates that are present in the same row.
     */
    private function removeLineCandidates(array $line, int $x, $y): void
    {
        $values = array_filter($line, fn($cell) => $cell !== 0);
        $this->candidatesMap[$y][$x] = array_diff($this->candidatesMap[$y][$x], $values);
    }

    /**
     * After a change in the candidatesmap, this function can be used to check if the candidates map for a cell holds
     * only one remaining candidate. Set the remaining single value in the board for the cell.
     * Update the candidates map for the cell's group, row, and column.
     */
    private function checkValue(int $y, int $x): void
    {
        $values = $this->candidatesMap[$y][$x];

        if (count($values) !== 1) {
            return;
        }

        $value = reset($values);
        $this->board[$y][$x] = $value;
        unset($this->candidatesMap[$y][$x]);
        $this->updateCandidates($y, $x, $value);
    }

    /**
     * After a board's cell assignment, use this method updates the other cells in the same group, column and row.
     */
    private function updateCandidates(int $y, int $x, int $value): void
    {
        $cellCoordinates = $this->getCellGroup($y, $x);
        foreach ($cellCoordinates as [$xPos, $yPos]) {
            if ($this->board[$yPos][$xPos] !== 0) continue;
            unset($this->candidatesMap[$yPos][$xPos][$value]);
            $this->checkValue($yPos, $xPos);
        }

        unset($xPos, $yPos);

        foreach (array_keys($this->candidatesMap[$y]) as $xPos) {
            if ($this->board[$y][$xPos] !== 0) continue;
            unset($this->candidatesMap[$y][$xPos][$value]);
            $this->checkValue($y, $xPos);
        }

        $candidateMapColumn = array_column($this->candidatesMap, $x);
        foreach (array_keys($candidateMapColumn) as $yPos) {
            if ($this->board[$yPos][$x] !== 0) continue;
            unset($this->candidatesMap[$yPos][$x][$value]);
            $this->checkValue($yPos, $x);
        }
    }

    /**
     * Calculate the grid's coordinates of a cell's group.
     */
    private function getCellGroup($y, $x): array
    {
        $groups = [
            [0,1,2],
            [3,4,5],
            [6,7,8],
        ];
        $xGroups = array_filter($groups, fn($group) => in_array($x, $group));
        $xGroup = reset($xGroups);
        $yGroups = array_filter($groups, fn($group) => in_array($y, $group));
        $yGroup = reset($yGroups);

        $coordinates = [];
        foreach ($xGroup as $xPos) {
            foreach ($yGroup as $yPos) {
                $coordinates[] = [$xPos, $yPos];
            }
        }

        return $coordinates;
    }
}