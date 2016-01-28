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
                $inputField[$c] = (int)$inputField[$c];
                if ($inputField[$c]<0 || $inputField[$c]>2) {
                    return false;
                }
                $this->field[$x][$y] = $inputField[$c];
                $c++;
            }
        }
        return true;
    }

    public function setMacroBoardFromString($string) //0,-1,0,0,0,2,0,0,0,0,..
    {
        $inputField = explode(",", $string);
        if (count($inputField) != 3*3) {
            return false;
        }
        $c = 0;

        for ($y = 0; $y < 3; $y++) {
            for ($x = 0; $x < 3; $x++) {
                $inputField[$c] = (int)$inputField[$c];
                if ($inputField[$c]<-1 || $inputField[$c]>2) {
                    return false;
                }
                $this->field[$x][$y] = $inputField[$c];
                $c++;
            }
        }
        return true;
    }

    public function printField() { // custom printing function for debugging
        for ($y = 0; $y < 9; $y++) {
            for ($x = 0; $x < 9; $x++) {
                echo ($this->field[$x][$y]==1?"O":($this->field[$x][$y]==2?"X":"_"));
            }
            echo "\n";
        }
    }

}