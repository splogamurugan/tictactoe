<?php
/**
 * To validate the board
 *
 */
class BoardValidator
{
    private $board;
    private $config;

    public function __construct(array $board, GameConfig $gc)
    {
        $this->board = $board;
        $this->config = $gc;
    }
    /**
     * common function to check all the rows/cols
     * @throws Exception
     * @return void
     */
    public function isValid()
    {
        $this->rowValid();
        $this->colValid();
    }
    /**
     * is all the rows are valid?
     * @throws Exception
     * @return void
     */
    private function rowValid()
    {
        if (count($this->board) !== $this->config->get('blocks')) {
            throw new Exception(
                'Invalid rows ('.count($this->board).'), '.$this->config->get('blocks').' rows expected!'
            );
        }
    }
    /**
     * Is all cols are having proper count
     * @throws Exception
     * @return void
     */
    private function colValid()
    {
        for ($i = 0; $i < count($this->board); $i++) {
            if (count($this->board[$i]) !== $this->config->get('blocks')) {
                throw new Exception(
                    'Invalid cols ('.count($this->board[$i]).'), '.$this->config->get('blocks').' cols expected!'
                );
            }
            $this->isValidPlayer($this->board[$i]);
        }
    }
    /**
     * is any invalid player playing?
     * @param  array $row row of the current line
     * @throws Exception
     * @return void
     **/
    private function isValidPlayer(array $row)
    {
        foreach ($row as $v) {
            if (!in_array(
                $v,
                [$this->config->get('player'),
                $this->config->get('opponent'),
                $this->config->get('space')
                ]
            )) {
                throw new Exception(
                    'Invalid players! Expected only '
                    .$this->config->get('player') .','
                    . $this->config->get('opponent')
                    .' & '.$this->config->get('space')
                );
                return;
            }
        }
    }
}
