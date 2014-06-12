<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GroundSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(80);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Ground');
    }

    function it_shows_borders_dimensions()
    {
        $this->getBorderDimension()->shouldReturn(80);
    }

    function it_return_the_ground_field()
    {
        $this->getGround()->shouldReturnTheGround(80,80);
    }

    function it_show_a_single_cell()
    {
        $this->getCell(0,0)->shouldReturnAnInstanceOf("Cell");
    }

    function it_separate_cells()
    {
        $this->getCell(0,0)->shouldNotBe($this->getCell(0, 1));
        $this->getCell(0,0)->shouldNotBe($this->getCell(1, 0));
    }

    public function getMatchers()
    {
        return [
            "returnTheGround" => function($ground, $rows, $cols) {
                $status = is_array($ground);
                if ($status) {
                    $status &= (count($ground) == $rows);

                    if ($status) {
                        foreach ($ground as $row) {
                            $status &= is_array($row);

                            if ($status) {
                                $status &= (count($row) == $cols);
                            }
                        }

                    }
                }

                return $status;
            }
        ];
    }
}

