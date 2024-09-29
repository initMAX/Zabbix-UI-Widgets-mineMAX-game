/*
** Copyright (C) 2001-2024 initMAX s.r.o.
**
** This program is free software: you can redistribute it and/or modify it under the terms of
** the GNU Affero General Public License as published by the Free Software Foundation, version 3.
**
** This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
** without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
** See the GNU Affero General Public License for more details.
**
** You should have received a copy of the GNU Affero General Public License along with this program.
** If not, see <https://www.gnu.org/licenses/>.
**/


class CWidgetMineMax extends CWidget {
    // Widget settings
    playerName = this._fields.player_name;
    columns = this._fields.columns;
    rows = this._fields.rows;
    difficulty = this._fields.difficulty;

    // Game state
    totalMines = (this.rows * this.columns) / 100 * (this.difficulty * 10);
    mineField = [];
    revealedCells = 0;
    gameOver = false;

    setContents(response) {
        super.setContents(response);
        this.setupArea();
        this.setupEventListeners();

        this.displayMessage('info', 'Difficulty: ' + this.getDifficultyName(this.difficulty));
    }

    // Get difficulty name
    getDifficultyName(difficulty) {
        switch (difficulty) {
            case 1:
                return 'beginner';
            case 2:
                return 'intermediate';
            case 3:
                return 'expert';
            default:
                return 'unknown';
        }
    }

    // Setup area
    setupArea() {
        // Create the minefield array
        for (let r = 0; r < this.rows; r++) {
            this.mineField[r] = [];
            for (let c = 0; c < this.columns; c++) {
                this.mineField[r][c] = { isMine: false, isRevealed: false, hasFlag: false, minesAround: 0 };
            }
        }

        // Place mines
        let minesPlaced = 0;

        while (minesPlaced < this.totalMines) {
            const row = Math.floor(Math.random() * this.rows);
            const col = Math.floor(Math.random() * this.columns);

            if (!this.mineField[row][col].isMine) {
                this.mineField[row][col].isMine = true;
                minesPlaced++;
            }
        }

        // Calculate numbers
        for (let r = 0; r < this.rows; r++) {
            for (let c = 0; c < this.columns; c++) {
                if (!this.mineField[r][c].isMine) {
                    let minesAround = 0;
                    for (let i = -1; i <= 1; i++) {
                        for (let j = -1; j <= 1; j++) {
                            const newRow = r + i;
                            const newCol = c + j;
                            if (newRow >= 0 && newRow < this.rows && newCol >= 0 && newCol < this.columns) {
                                if (this.mineField[newRow][newCol].isMine) {
                                    minesAround++;
                                }
                            }
                        }
                    }
                    this.mineField[r][c].minesAround = minesAround;
                }
            }
        }

        // Clean up the area
        const cells = this._body.querySelectorAll('.minemax__area > div');

        cells.forEach(cell => {
            cell.className = '';
            cell.innerText = '';
        });
    }

    // Reveal a cell
    revealCell(row, col) {
        if (row < 0 || row >= this.rows || col < 0 || col >= this.columns) return;

        const cell = this.mineField[row][col];
        if (cell.isRevealed) return;

        const div = this._body.querySelector(`div[data-row="${row}"][data-column="${col}"]`);

        if (cell.isMine) {
            div.classList.add('mine--exploded');
            this.gameOver = true;
            this.revealMineCells();

            this.displayMessage('failed', 'Game over! Hahaha, ' + this.playerName + '!');
            
            return;
        }

        cell.isRevealed = true;

        this.revealedCells++;

        div.classList.add('revealed');
        div.classList.remove('flag');

        if (cell.minesAround > 0) {
            div.innerText = cell.minesAround;
            div.dataset.minesAround = cell.minesAround;
        } else {
            // Reveal surrounding cells
            for (let i = -1; i <= 1; i++) {
                for (let j = -1; j <= 1; j++) {
                    this.revealCell(row + i, col + j);
                }
            }
        }

        // Check for win
        if (this.revealedCells === this.rows * this.columns - this.totalMines) {
            this.gameOver = true;

            this.displayMessage('success', 'Game over! Congratulations, ' + this.playerName + '!');
        }
    }

    // Reveals all cells
    revealMineCells() {
        for (let r = 0; r < this.rows; r++) {
            for (let c = 0; c < this.columns; c++) {
                const cell = this.mineField[r][c];

                if (cell.isMine) {
                    const div = this._body.querySelector(`div[data-row="${r}"][data-column="${c}"]`);
                    div.classList.add('mine');
                }

                if (cell.hasFlag && !cell.isMine) {
                    const div = this._body.querySelector(`div[data-row="${r}"][data-column="${c}"]`);
                    div.classList.add('flag--wrong');
                }
            }
        }
    }

    toggleFlag(row, col) {
        const cell = this.mineField[row][col];
        cell.hasFlag = !cell.hasFlag;

        const div = this._body.querySelector(`div[data-row="${row}"][data-column="${col}"]`);
        div.classList.toggle('flag');
    }

    displayMessage(type, message) {
        const messageElement = this._body.querySelector('.minemax__message');
        messageElement.class = type;
        messageElement.innerText = message;
    }

    // Reset the game
    resetGame() {
        // Reset game state
        this.gameOver = false;
        this.revealedCells = 0;

        // Reset minefield
        this.setupArea();

        // Reset message
        this.displayMessage('info', 'Difficulty: ' + this.getDifficultyName(this.difficulty));
    }

    // Handle cell left click
    handleCellClick(event) {
        if (this.gameOver) return;

        const cell = event.target;
        const row = parseInt(cell.getAttribute('data-row'));
        const col = parseInt(cell.getAttribute('data-column'));

        if (this.mineField[row][col].hasFlag) return;

        this.revealCell(row, col);
    }

    // Handle cell right click
    handleCellRightClick(event) {
        event.preventDefault();
        
        if (this.gameOver) return;

        const cell = event.target;
        const row = parseInt(cell.getAttribute('data-row'));
        const col = parseInt(cell.getAttribute('data-column'));

        if (this.mineField[row][col].isRevealed) return;

        this.toggleFlag(row, col);
    }

    // Add event listeners to cells
    setupEventListeners() {
        const cells = this._body.querySelectorAll('.minemax__area > div');
        cells.forEach(cell => {
            cell.addEventListener('click', this.handleCellClick.bind(this));
            cell.addEventListener('contextmenu', this.handleCellRightClick.bind(this));
        });

        const resetButton = this._body.querySelector('.minemax__reset');
        resetButton.addEventListener('click', this.resetGame.bind(this));
    }

    // Remove padding on the bottom of the widget
    hasPadding() {
        return false;
    }
}
