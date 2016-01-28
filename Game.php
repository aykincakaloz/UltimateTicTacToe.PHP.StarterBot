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
            }

            if ($commandParams['command'] === 'custom') {
                if ($commandParams['arg'] === 'print') {
                    $this->map->printField();
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
}