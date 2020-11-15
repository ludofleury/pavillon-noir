<?php

namespace EventSourcing;

use Ramsey\Uuid\UuidInterface;

abstract class AggregateRoot extends Entity
{
    protected UuidInterface $id;

    protected array $stream = [];

    protected int $sequence = -1;

    abstract protected function __construct();

    /**
     * Load an AR from an existing event stream
     */
    static public function load(UuidInterface $id, Stream $stream): self
    {
        $aggregateRoot = new static();
        $aggregateRoot->id = $id;

        foreach ($stream as $message) {
            ++$aggregateRoot->sequence;
            $aggregateRoot->handle($message->getEvent());
        }

        return $aggregateRoot;
    }

    public function getUncommittedEvents(): Stream
    {
        $stream = new Stream($this->stream);
        $this->stream = [];

        return $stream;
    }

    /**
     * Record an event to the event stream and apply it to the AR
     */
    protected function apply(Event $event): void
    {
        $this->handleRecursively($event);

        ++$this->sequence;
        $this->stream[] = new Message(
            static::class,
            $this->getId(),
            $this->sequence,
            $event
        );
    }

    abstract public function getId(): UuidInterface;
}