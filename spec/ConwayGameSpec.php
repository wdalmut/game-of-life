<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Cell;
use SplDoublyLinkedList;

class ConwayGameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('ConwayGame');
        $this->shouldHaveType('GameStrategy');
    }

    function it_maintains_cell_alive(Cell $cell, SplDoublyLinkedList $neighbors)
    {
        $aliveCell = new Cell();
        $aliveCell->setStatus(Cell::ALIVE);
        $aliveCell->applyState();

        $neighbors->rewind()->willReturn($neighbors);
        $neighbors->valid()->willReturn(true, true, true, false);
        $neighbors->next()->willReturn($aliveCell, $aliveCell, $aliveCell, null);
        $neighbors->count()->willReturn(3);
        $neighbors->current()->willReturn($aliveCell);

        $cell->isAlive()->willReturn(true);

        $cell->setStatus(Cell::ALIVE)->shouldBeCalled();

        $this->nextEra($cell, $neighbors);
    }

    function it_kill_the_cell_because_of_overcrowding(Cell $cell, SplDoublyLinkedList $neighbors)
    {
        $aliveCell = new Cell();
        $aliveCell->setStatus(Cell::ALIVE);
        $aliveCell->applyState();

        $neighbors->rewind()->willReturn($neighbors);
        $neighbors->valid()->willReturn(true, true, true, true, false);
        $neighbors->next()->willReturn($aliveCell, $aliveCell, $aliveCell, $aliveCell, null);
        $neighbors->count()->willReturn(3);
        $neighbors->current()->willReturn($aliveCell);

        $cell->isAlive()->willReturn(true);

        $cell->setStatus(Cell::DEAD)->shouldBeCalled();

        $this->nextEra($cell, $neighbors);
    }

    function it_kill_the_cell_because_of_underpopulation(Cell $cell, SplDoublyLinkedList $neighbors)
    {
        $aliveCell = new Cell();
        $aliveCell->setStatus(Cell::ALIVE);
        $aliveCell->applyState();

        $deadCell = new Cell();
        $deadCell->setStatus(Cell::DEAD);
        $deadCell->applyState();

        $neighbors->rewind()->willReturn($neighbors);
        $neighbors->valid()->willReturn(true, true, true, false);
        $neighbors->next()->willReturn($aliveCell, $deadCell, $deadCell, null);
        $neighbors->count()->willReturn(3);
        $neighbors->current()->willReturn($aliveCell, $deadCell, $deadCell, null);

        $cell->isAlive()->willReturn(true);

        $cell->setStatus(Cell::DEAD)->shouldBeCalled();

        $this->nextEra($cell, $neighbors);
    }

    function it_bring_the_cell_back_to_life_because_of_reproduction(Cell $cell, SplDoublyLinkedList $neighbors)
    {
        $aliveCell = new Cell();
        $aliveCell->setStatus(Cell::ALIVE);
        $aliveCell->applyState();

        $neighbors->rewind()->willReturn($neighbors);
        $neighbors->valid()->willReturn(true, true, true, false);
        $neighbors->next()->willReturn($aliveCell, $aliveCell, $aliveCell, null);
        $neighbors->count()->willReturn(3);
        $neighbors->current()->willReturn($aliveCell);

        $cell->isAlive()->willReturn(false);
        $cell->getStatus()->willReturn(Cell::DEAD);

        $cell->setStatus(Cell::ALIVE)->shouldBeCalled();

        $this->nextEra($cell, $neighbors);
    }


    function it_keeps_the_cell_dead(Cell $cell, SplDoublyLinkedList $neighbors)
    {
        $aliveCell = new Cell();
        $aliveCell->setStatus(Cell::ALIVE);
        $aliveCell->applyState();

        $deadCell = new Cell();
        $deadCell->setStatus(Cell::DEAD);
        $deadCell->applyState();

        $neighbors->rewind()->willReturn($neighbors);
        $neighbors->valid()->willReturn(true, true, true, false);
        $neighbors->next()->willReturn($aliveCell, $aliveCell, $deadCell, null);
        $neighbors->count()->willReturn(3);
        $neighbors->current()->willReturn($aliveCell, $aliveCell, $deadCell, null);

        $cell->isAlive()->willReturn(false);
        $cell->getStatus()->willReturn(Cell::DEAD);

        $cell->setStatus(Cell::DEAD)->shouldBeCalled();

        $this->nextEra($cell, $neighbors);
    }
}
