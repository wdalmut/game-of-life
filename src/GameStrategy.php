<?php

interface GameStrategy
{
    public function nextEra(Cell $cell, SplDoublyLinkedList $neighbors);
}
