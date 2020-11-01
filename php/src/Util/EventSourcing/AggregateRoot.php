<?php

namespace App\Util\EventSourcing;
use Ramsey\Uuid\UuidInterface;

abstract class AggregateRoot
{
    protected UuidInterface $id;

    protected array $stream = [];

    protected int $sequence = -1;

    abstract public function getId(): UuidInterface;

    public function getUncommittedEvents(): Stream
    {
        $stream = new Stream($this->stream);
        $this->stream = [];

        return $stream;
    }

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

    protected function apply(Event $event): void
    {
        $this->handle($event);

        ++$this->sequence;
        $this->stream[] = new Message(
            static::class,
            $this->getId(),
            $this->sequence,
            $event
        );
    }

    protected function handle(Event $event): void
    {
        $method = $this->getApplyMethod($event);

        if (!method_exists($this, $method)) {
            die('toto');
            return;
        }

        $this->$method($event);
    }

    private function getApplyMethod(Event $event): string
    {
        $classParts = explode('\\', get_class($event));

        return 'apply'.end($classParts);
    }
}