<?php

namespace App\Util\EventSourcing;

abstract class AggregateRoot
{
    protected $stream = [];

    protected $sequence = -1;

    public function getUncommittedEvents(): Stream
    {
        $stream = new Stream($this->stream);
        $this->stream = [];

        return $stream;
    }

    protected function nextSequence(): int
    {
        return ++$this->sequence;
    }
}