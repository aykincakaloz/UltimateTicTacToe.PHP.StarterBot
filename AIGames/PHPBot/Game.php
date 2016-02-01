<?php
namespace AIGames\PHPBot;

/**
 * Class Game
 * @package AIGames\PHPBot
 */
class Game
{
    private $settings = [];
    private $map;
    private $validSettings = ['timebank', 'time_per_move', 'player_names', 'your_bot', 'your_botid'];

    public function __construct()
    {
        $this->map = new Map();
        $this->ai = new AI($this->map);
    }

    /**
     * Returns the requested setting variable
     * @param $setting
     * @return null
     */
    public function get($setting)
    {
        if (array_key_exists($setting, $this->settings)) {
            return $this->settings[$setting];
        } else {
            return null;
        }
    }

    /**
     * Main Function that continuously receives STDIN input
     */
    public function run()
    {
        $handle = fopen("php://stdin", "r");
        while (1) {
            $command = trim(fgets($handle));
            if ($command == "") {
                continue;
            }

            if ($command == "exit") {
                $this->output("bye");
                break;
            }

            $this->processInput($command);

        }
    }

    public function output($string)
    {
        echo $string."\n";
    }

    /**
     * Processes the command input and calls the required method.
     * Returns true if command is accepted, false if the command is unrecognized
     *
     * @param $input
     * @return bool
     */
    public function processInput($input)
    {
        preg_match("/^(?<command>settings|update game|action|custom) (?<arg>\S+) (?<parameter>.+)$/", $input, $commandParams);
        if (!count($commandParams)) {
            $this->output("Undefined Command");

            return false;
        }


        if ($commandParams['command'] === 'settings') {
            if (false === $this->set($commandParams['arg'], $commandParams['parameter'])) {
                $this->output("Undefined setting");

                return true;
            }
        }

        if ($commandParams['command'] === 'update game') {
            if ($commandParams['arg'] === 'field') {
                return $this->map->setFieldFromString($commandParams['parameter']);
            }

            if ($commandParams['arg'] === 'macroboard') {
                return $this->map->setMacroBoardFromString($commandParams['parameter']);
            }
        }

        if ($commandParams['command'] === 'action') {
            if ($commandParams['arg'] === 'move') {
                $this->makeMove();

                return true;
            }
        }

        if ($commandParams['command'] === 'custom') {
            if ($commandParams['arg'] === 'print') {
                if ($commandParams['parameter'] === 'field') {
                    $this->map->printField();

                    return true;
                }
                if ($commandParams['parameter'] === 'macroboard') {
                    $this->map->printMacroBoard();

                    return true;
                }
            }

        }

        return false;
    }

    /**
     * Receives a game setting and stores it. Returns false if setting is not recognized
     *
     * @param $setting
     * @param $value
     * @return bool
     */
    public function set($setting, $value)
    {
        if (!in_array($setting, $this->validSettings)) {
            return false;
        }

        $this->settings[$setting] = $value;

        //Update the AI of the change:
        $this->ai->updateSettings($this->settings);

        return true;
    }

    /**
     * Invokes the AI, provides it with the game state and runs the move command
     */
    public function makeMove()
    {
        /**
         * @var Move $move
         */
        $move = $this->ai->move();

        $this->output("place_move ".$move->getX()." ".$move->getY());
    }
}