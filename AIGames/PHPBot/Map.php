<?php
namespace AIGames\PHPBot;

/**
 * Class Map
 * @package AIGames\PHPBot
 */
class Map
{
    public $field;
    public $macroBoard;

    /**
     * Map constructor.
     */
    public function __construct()
    {
        $this->field = array(
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
        );
        $this->macroBoard = array(
            array(0, 0, 0),
            array(0, 0, 0),
            array(0, 0, 0),
        );
    }


    /**
     * Set the field from input string
     * Example:
     * 0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,0,0,0,
     * 0,0,0,0,0,0,0,2,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,
     * 0,0,2,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0
     *
     * @param $string
     * @return bool
     */
    public function setFieldFromString($string) //0,0,0,0,0,2,0,0,0,0,..
    {
        $inputField = explode(",", $string);
        if (count($inputField) != 9 * 9) {
            return false;
        }
        $c = 0;

        for ($y = 0; $y < 9; $y++) {
            for ($x = 0; $x < 9; $x++) {
                $inputField[$c] = (int)$inputField[$c];
                if ($inputField[$c] < 0 || $inputField[$c] > 2) {
                    return false;
                }
                $this->field[$x][$y] = $inputField[$c];
                $c++;
            }
        }

        return true;
    }

    /**
     * Set the MacroBoard from input string
     * Example: 0,-1,0,0,0,2,0,0,0
     *
     * @param $string
     * @return bool
     */
    public function setMacroBoardFromString($string)
    {
        $inputField = explode(",", $string);
        if (count($inputField) != 3 * 3) {
            return false;
        }
        $c = 0;

        for ($y = 0; $y < 3; $y++) {
            for ($x = 0; $x < 3; $x++) {
                $inputField[$c] = (int)$inputField[$c];
                if ($inputField[$c] < -1 || $inputField[$c] > 2) {
                    return false;
                }
                $this->macroBoard[$x][$y] = $inputField[$c];
                $c++;
            }
        }

        return true;
    }

    /**
     * Checks all the MacroBoard(s) which are applicable for empty squares,
     * giving an array of all possible moves for the round
     *
     * @return array
     */
    public function getAvailableMoves()
    {
        $moves = [];
        for ($y = 0; $y < 9; $y++) {
            for ($x = 0; $x < 9; $x++) {
                if ($this->isInActiveMacroBoard($x, $y) && $this->field[$x][$y] == 0) {
                    $moves[] = new Move($x, $y);
                }
            }
        }

        return $moves;
    }

    /**
     * Checks if the given coordinates are within the active MacroBoard
     *
     * @param int $x
     * @param int $y
     * @return bool
     */
    public function isInActiveMacroBoard($x, $y)
    {
        return ($this->macroBoard[(int)floor($x / 3)][(int)floor($y / 3)] == -1);
    }

    /**
     * Custom printing function for debugging (NOT USED IN THE COMPETITION)
     */
    public function printField()
    {
        for ($y = 0; $y < 9; $y++) {
            for ($x = 0; $x < 9; $x++) {
                echo($this->field[$x][$y] == 1 ? "O" : ($this->field[$x][$y] == 2 ? "X" : "_"));
            }
            echo "\n";
        }
    }

    /**
     * Custom printing function for debugging (NOT USED IN THE COMPETITION)
     */
    public function printMacroBoard()
    {
        for ($y = 0; $y < 3; $y++) {
            for ($x = 0; $x < 3; $x++) {
                echo($this->macroBoard[$x][$y] == -1 ? "_" : "X");
            }
            echo "\n";
        }
    }

}