<?php
require_once __DIR__ . '/vendor/autoload.php';

$ground = null;
$strategy = new ConwayGame();

if  (count($argv) == 2) {
    $ground = from_file($argv[1]);
} else {
    $ground = new Ground(40);
    random_cell($ground);
}

while(true) {
    print_ground($ground);

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
}

function print_ground(Ground $ground)
{
    system("clear");

    ob_start();
    for ($i=0; $i<$ground->getBorderDimension(); $i++) {
        for ($j=0; $j<$ground->getBorderDimension(); $j++) {
            $cell = $ground->getCell($i, $j);

            if ($cell->isAlive()) {
                echo "0";
            } else {
                echo " ";
            }
        }
        echo PHP_EOL;
    }
    ob_flush();
    ob_end_clean();

    usleep(100000);
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

function random_cell(Ground $ground)
{
    for ($i=0; $i<$ground->getBorderDimension(); $i++) {
        for ($j=0; $j<$ground->getBorderDimension(); $j++) {
            $cell = $ground->getCell($i, $j);

            if (rand(0,5) == 1) {
                $cell->setStatus(Cell::ALIVE);
                $cell->applyState();
            }
        }
    }
}

function from_file($file)
{
    if (!file_exists($file)) {
        throw new RuntimeExcepiton("File {$file} doesn't exists");
    }

    $fh = fopen($file, 'r');

    $rows = 0;
    $cols = 0;
    while (($line = fgets($fh)) !== false) {
        $rows++;
        $actualCol = strlen($line);
        if ($actualCol > $cols) {
            $cols = $actualCol;
        }
    }

    $ground = null;
    if ($rows > $cols) {
        $ground = new Ground($rows);
    } else {
        $ground = new Ground($cols);
    }


    $row = 0;
    rewind($fh);
    while (($line = fgets($fh)) !== false) {
        $line = str_replace(array("\n", "\r", "\r\n"), "", $line);
        for ($col=0; $col<strlen($line); $col++) {
            $char = $line[$col];

            $cell = $ground->getCell($row, $col);

            if ($char != ' ') {
                $cell->setStatus(Cell::ALIVE);
            }

            $cell->applyState();
        }

        $row++;
    }

    return $ground;
}
