<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Cell;

class CellSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Cell');
    }

    function it_is_dead()
    {
        $this->isAlive()->shouldReturn(false);
    }

    function it_can_change_status_only_when_we_move_the_era()
    {
        $this->setStatus(Cell::ALIVE);
        $this->isAlive()->shouldReturn(false);
    }

    function it_can_change_status_at_new_era()
    {
        $this->setStatus(Cell::ALIVE);
        $this->applyState();
        $this->isAlive()->shouldReturn(true);
    }

    function it_check_the_status()
    {
        $this->shouldThrow("RuntimeException")->duringSetStatus("walter");
    }
}
