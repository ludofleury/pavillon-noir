<?php

namespace App\Util\EventSourcing;

use Countable;
use IteratorAggregate;
use ArrayIterator;
use ArrayAccess;
use Exception;

final class Stream implements IteratorAggregate, Countable, ArrayAccess
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

    public function count(): int
    {
        return count($this->events);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->events[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->events[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        throw new Exception('Unable to set an event in a stream');
    }

    public function offsetUnset($offset): void
    {
        throw new Exception('Unable to unset an event in a stream');
    }
}