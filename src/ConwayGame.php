<?php

class ConwayGame implements GameStrategy
{
    public function nextEra(Cell $cell, SplDoublyLinkedList $neighbors)
    {
        if ($cell->isAlive()) {
            $this->handleAliveCell($cell, $neighbors);
        } else {
            $this->handleDeadCell($cell, $neighbors);
        }
    }

    private function handleAliveCell(Cell $cell, SplDoublyLinkedList $neighbors)
    {
        $aliveNeighbors = $this->countAliveNeighbors($neighbors);

        if ($aliveNeighbors == 2 || $aliveNeighbors == 3) {
            $cell->setStatus(Cell::ALIVE);
        } else {
            $cell->setStatus(Cell::DEAD);
        }
    }

    private function handleDeadCell(Cell $cell, SplDoublyLinkedList $neighbors)
    {
        $aliveNeighbors = $this->countAliveNeighbors($neighbors);

        if ($aliveNeighbors == 3) {
            $cell->setStatus(Cell::ALIVE);
        } else {
            $cell->setStatus(Cell::DEAD);
        }
    }

    private function countAliveNeighbors(SplDoublyLinkedList $neighbors)
    {
        $aliveNeighbors = 0;
        foreach ($neighbors as $neighbor) {
            $aliveNeighbors += $neighbor->getStatus();
        }

        return $aliveNeighbors;
    }
}
