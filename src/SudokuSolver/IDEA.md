# Sudoku Solver

## Sudoku
In a 9x9 grid are nine 3x3 groups and nine lines and columns.  
In each line, column and group each cell may contain a number of 1 to 9.  
The number in a cell must be unique in the same line, column and group.

## Implementation idea
1. Build a candidate map that contains a range of 1-9 as candidates for all cells that still have unknown numbers.
2. Iterate over all cells and remove candidates that are not possible, because the number is already in the same line, column or group.
3. When a number is removed from the candidate map for a cell, check if the candidates only have one remaining number.
   a. If yes, add the number to the cell of the actual grid, update the candidate map for all cells in the same line, column and group to remove the number that was just added.
   b. If no, continue to the next cell.
4. Iterate over all cells until all unknown cells are resolved.

# Methods
- solve() to initiate the solving process.
- buildCandidateMap() to build the candidate map when the grid is initialized.
- removeGroupCandidates() removes the candidates that are not possible because the number is already in the same group.
- removeRowCandidates() removes the candidates that are not possible because the number is already in the same row.
- removeColumnCandidates() removes the candidates that are not possible because the number is already in the same column.
- checkCandidates() checks if the candidates only have one remaining number.
- updateCandidates() updates the candidate map for all cells in the same line, column and group to remove the number that was just added.