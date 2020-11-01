<?php

namespace App\Util\EventSourcing;

use IteratorAggregate;
use ArrayIterator;

final class Stream implements IteratorAggregate
{
    private array $events;

    public function __construct(array $events)
    {
        $this->events = $events;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->events);
    }
}