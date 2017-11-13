<?php
/**
 * a simple implementation to manage the config throughout this app
 */
class GameConfig
{
    private $config;
    private $defaultConfig;
    /**
     * Constructor
     * @return void
     */
    public function __construct()
    {
        $this->defaultConfig = [
            'player'   => 'o',
            'opponent' => 'x',
            'blocks'   => 3,
            'space'    => '',
            'playerScore' => 10,
            'opponentScore' => 0
        ];
        if (!file_exists(__DIR__."/../config.ini")) {
            return;
        }
        $this->config = parse_ini_file(__DIR__."/../config.ini", false, INI_SCANNER_TYPED);
    }
    /**
     * to get a config variable. returns the entire array if no var requested
     * @param string  $var variable
     * @return string value of the config
     */
    public function get($var = null)
    {
        if ($var === null) {
            return $this->config?$this->config:$this->defaultConfig;
        }
        return isset($this->config[$var])?$this->config[$var]:$this->getDefaultConfig($var);
    }
    /**
     * to get the default config if no config exist
     * @param string $var config var
     * @return string value of the config
     */
    private function getDefaultConfig($var)
    {
        if (isset($this->defaultConfig[$var])) {
            return $this->defaultConfig[$var];
        } else {
            throw new Exception('Not a valid config requested '.$var);
        }
    }
}
