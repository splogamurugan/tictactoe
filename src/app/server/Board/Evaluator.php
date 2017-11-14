<?php
namespace App\Server\Board;

/**
 * To evaluate the board
 */
class Evaluator
{
    private $blocks;
    /**
     * Constructor
     * @param array blocks number of blocks
     * @return void
     */
    public function __construct($blocks = 3)
    {
        $this->blocks = $blocks;
    }
    /**
     * is contains the elem in the board
     * @param array  $board
     * @param string $elem
     *
     * @return bool true if contains/else false
     */
    public function isContains(array $board, $elem)
    {
        for ($i = 0; $i<$this->blocks; $i++) {
            for ($j = 0; $j<$this->blocks; $j++) {
                if ($board[$i][$j] == $elem) {
                    return true;
                }
            }
        }
        return false;
    }
    /**
     * Is any player can strike and win the match
     * @param array $board
     *
     * @return string the winning player / '' if no winners
     */
    public function strikableBy(array $board)
    {
        // row match
        for ($row = 0; $row<$this->blocks; $row++) {
            $cols = array_unique($board[$row]);
            if (count($cols) == 1 && $cols[0]) {
                return $cols[0];
            }
        }

        //col match
        for ($col = 0; $col<$this->blocks; $col++) {
            if ($board[0][$col] == $board[1][$col]
                && $board[1][$col] == $board[2][$col]
            ) {
                return $board[0][$col];
            }
        }
     
        // backward cross
        if ($board[0][0] == $board[1][1]
            && $board[0][0] == $board[2][2]
        ) {
            return $board[0][0];
        }

        //forward cross
        if ($board[0][2]==$board[1][1]
            && $board[0][2]==$board[2][0]
        ) {
            return $board[0][2];
        }

        return '';
    }
}
