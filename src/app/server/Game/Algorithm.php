<?php
/**
 * Algorithm to find a best move with maximising the chance of bot.
 * Also by minimizing the chance of player
 */
class Algorithm
{
    private $conf;
    private $max = true;
    private $gameConfig;
    private $boardEvaluator;
    private $scores = [];
    /**
     * Constuctor
     * @param GameConfig     $gc
     * @param BoardEvaluator $bv
     * @return void
     */
    public function __construct(GameConfig $gc, BoardEvaluator $bv)
    {
        $this->gameConfig     = $gc;
        $this->boardEvaluator = $bv;
        $this->scores[$this->gameConfig->get('player')]
            = $this->gameConfig->get('playerScore');
        $this->scores[$this->gameConfig->get('opponent')]
            = $this->gameConfig->get('opponentScore');
        $this->conf['best'][$this->max]  = -1000;
        $this->conf['best'][!$this->max] = 1000;
        $this->conf['function'][$this->max] = 'max';
        $this->conf['function'][!$this->max] = 'min';
        $this->conf['player'][$this->max] = $this->gameConfig->get('player');
        $this->conf['player'][!$this->max] = $this->gameConfig->get('opponent');
    }
    /**
     * current score of the board
     *
     * @return integer
     */
    public function getScore($player)
    {
        return (isset($this->scores[$player]))?$this->scores[$player]:0;
    }
    /**
     * https://en.wikipedia.org/wiki/Minimax
     * @param array   $board
     * @param integer $depth
     * @param bool    $isMax
     *
     * @return integer
     */
    public function minimax(array $board, $depth, $isMax)
    {
        $isMax = (bool)$isMax;
        $space = $this->gameConfig->get('space');
        $score = $this->getScore($this->boardEvaluator->strikableBy($board));
        if ($score !== 0) {
            return $score;
        }
        if (!$this->boardEvaluator->isContains($board, $space)) {
            return 0;
        }
        $best = $this->conf['best'][$isMax];
        $blocks = $this->gameConfig->get('blocks');
        for ($i = 0; $i<$blocks; $i++) {
            for ($j = 0; $j<$blocks; $j++) {
                if ($board[$i][$j] === $space) {
                    $board[$i][$j] = $this->conf['player'][$isMax];
                    $best = $this->conf['function'][$isMax](
                        $best,
                        $this->minimax($board, $depth+1, !$isMax)
                    );
                    $board[$i][$j] = $space; //put the space back
                }
            }
        }
        return $best;
    }
}
