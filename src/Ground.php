<?php

class Ground
{
    private $ground;

    public function __construct($border)
    {
        $this->createThePlayGround($border);
    }

    public function getBorderDimension()
    {
        return count($this->ground);
    }

    public function getGround()
    {
        return $this->ground;
    }

    public function getCell($row, $col)
    {
        return $this->ground[$row][$col];
    }

    private function createThePlayGround($border)
    {
        for ($i=0; $i<$border; $i++ ) {
            $this->ground[$i] = [];
            for ($j=0; $j<$border; $j++) {
                $this->ground[$i][$j] = new Cell();
            }
        }
    }
}
