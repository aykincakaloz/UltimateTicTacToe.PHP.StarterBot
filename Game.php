<?php

class Game
{
    private $settings = [];
    private $map;

    public function __construct()
    {
        $this->map = new Map();
    }

    public function get($setting)
    {
        if (array_key_exists($setting, $this->settings)) {
            return $this->settings[$setting];
        }
    }

    public function run()
    {
        $handle = fopen("php://stdin", "r");
        while (1) {
            $command = trim(fgets($handle));
            if ($command == "") {
                continue;
            }

            if ($command == "exit") {
                echo "bye\n";
                break;
            }

            preg_match("/^(?<command>settings|update game|action|custom) (?<arg>\S+) (?<parameter>.+)$/", $command, $commandParams);
            if (!count($commandParams)) {
                echo "Undefined Command\n";
                continue;
            }


            if ($commandParams['command'] === 'settings') {
                if (false === $this->set($commandParams['arg'], $commandParams['parameter'])) {
                    echo "Undefined setting\n";
                    continue;
                }
            }

            if ($commandParams['command'] === 'update game') {
                if ($commandParams['arg'] === 'field') {
                    $this->map->setFieldFromString($commandParams['parameter']);
                }

                if ($commandParams['arg'] === 'macroboard') {
                    $this->map->setMacroBoardFromString($commandParams['parameter']);
                }
            }

            if ($commandParams['command'] === 'action') {
                if ($commandParams['arg'] === 'move') {
                    $this->makeMove();
                }
            }

            if ($commandParams['command'] === 'custom') {
                if ($commandParams['arg'] === 'print') {
                    if ($commandParams['parameter'] === 'field') {
                        $this->map->printField();
                    }
                    if ($commandParams['parameter'] === 'macroboard') {
                        $this->map->printMacroBoard();
                    }
                }
            }
        }
    }

    public function set($setting, $value)
    {
        if (!in_array($setting, ['timebank', 'time_per_move', 'player_names', 'your_bot', 'your_botid'])) {
            return false;
        }

        $this->settings[$setting] = $value;

        return true;
    }

    public function makeMove()
    {
        $availableMoves = $this->map->getAvailableMoves();

        /** Make a random move
         * @var Move $move
        */
        $move = $availableMoves[rand(0,count($availableMoves)-1)];

        echo "place_move ".$move->getX()." ".$move->getY()."\n";
    }
}