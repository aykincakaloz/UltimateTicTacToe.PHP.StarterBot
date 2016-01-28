<?php

class Map
{
    public $field;
    public $macroBoard;

    /**
     * Map constructor.
     */
    public function __construct()
    {
        $this->field = [];
        $this->macroBoard = [];
    }


    public function setFieldFromString($string) //0,0,0,0,0,2,0,0,0,0,..
    {
        $inputField = explode(",", $string);
        if (count($inputField) != 9 * 9) {
            return false;
        }
        $c = 0;

        for ($y = 0; $y < 9; $y++) {
            for ($x = 0; $x < 9; $x++) {
                $this->field[$x][$y] = $inputField[$c];
                $c++;
            }
        }

        var_dump($this->field);
        return true;
    }

    public function printField() {
        for ($y = 0; $y < 9; $y++) {
            for ($x = 0; $x < 9; $x++) {
                echo $this->field[$x][$y];
            }
            echo "\n";
        }
    }

}