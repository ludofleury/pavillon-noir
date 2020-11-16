<?php

namespace EventSourcing;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Message
{
    /**
     * @var UuidInterface Message unique identifier
     */
    private UuidInterface $id;
    /**
     * @var string Aggregate root FQCN
     */
    protected string $aggregateRootType;

    protected UuidInterface $aggregateRootId;
    /**
     * @var int Zero-indexed event sequence, unique per aggregate root
     */
    protected int $sequence;

    protected DateTimeImmutable $recordedAt;
    /**
     * @var string Event FQCN
     */
    protected string $eventType;
    /**
     * @ORM\Column(type="json", options={"jsonb": true})
     */
    protected array $data;
    /**
     * @var Event|null internal object cache purpose
     */
    protected ?Event $event;

    public function __construct(string $aggregateRootType, UuidInterface $aggregateRootId, $sequence, Event $event)
    {
        $this->id = Uuid::uuid1();
        $this->aggregateRootType = $aggregateRootType;
        $this->aggregateRootId = $aggregateRootId;
        $this->sequence = $sequence;
        $this->recordedAt = new DateTimeImmutable();
        $this->eventType = get_class($event);
        $this->data = $event->toArray();
        $this->event = $event;
    }

    public function getEvent(): Event
    {
        if ($this->event === null) {
            $this->event = call_user_func_array([$this->eventType, 'fromArray'], [$this->data]);
        }

        return $this->event;
    }
}