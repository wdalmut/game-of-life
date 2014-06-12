<?php

class Cell
{
    const ALIVE = 1;
    const DEAD = 0;

    private $status = self::DEAD;
    private $nextStatus = self::DEAD;

    public function isAlive()
    {
        return ($this->status == self::ALIVE);
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        if (!in_array($status, [self::ALIVE, self::DEAD], true)) {
            throw new RuntimeException("Status {$status} not available");
        }

        $this->nextStatus = $status;
    }

    public function applyState()
    {
        $this->status = $this->nextStatus;
    }
}
