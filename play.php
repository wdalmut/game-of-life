<?php
require_once __DIR__ . '/vendor/autoload.php';

$ground = new Ground(40);
$strategy = new ConwayGame();

for ($i=0; $i<$ground->getBorderDimension(); $i++) {
    for ($j=0; $j<$ground->getBorderDimension(); $j++) {
        $cell = $ground->getCell($i, $j);

        if (rand(0,1) == 1) {
            $cell->setStatus(Cell::ALIVE);
            $cell->applyState();
        }
    }
}


while(true) {
    for ($i=0; $i<$ground->getBorderDimension(); $i++) {
        for ($j=0; $j<$ground->getBorderDimension(); $j++) {
            $cell = $ground->getCell($i, $j);

            $neighbors = get_neighbors($ground, $i, $j);

            $strategy->nextEra($cell, $neighbors);
        }
    }


    for ($i=0; $i<$ground->getBorderDimension(); $i++) {
        for ($j=0; $j<$ground->getBorderDimension(); $j++) {
            $cell = $ground->getCell($i, $j);
            $cell->applyState();
        }
    }

    system("clear");

    ob_start();
    for ($i=0; $i<$ground->getBorderDimension(); $i++) {
        for ($j=0; $j<$ground->getBorderDimension(); $j++) {
            $cell = $ground->getCell($i, $j);

            if ($cell->isAlive()) {
                echo "♥ ";
            } else {
                echo " ";
            }
        }
        echo PHP_EOL;
    }
    ob_flush();
    ob_end_clean();

    sleep(1);
}

function get_neighbors(Ground $ground, $i, $j)
{
    $borderDimension = $ground->getBorderDimension();

    $positions = [
        [$i-1, $j-1], [$i-1, $j], [$i-1, $j+1],
        [$i, $j-1], [$i, $j+1],
        [$i+1, $j-1], [$i+1, $j], [$i+1, $j+1],
    ];

    $neighbors = new SplDoublyLinkedList();
    foreach ($positions as $pos) {
        if ($pos[0] >= 0 && $pos[0] < $borderDimension) {
            if ($pos[1] >= 0 && $pos[1] < $borderDimension) {
                $neighbors->push($ground->getCell($pos[0], $pos[1]));
            }
        }
    }

    return $neighbors;
}

