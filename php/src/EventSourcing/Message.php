<?php

namespace EventSourcing;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="EventSourcing\EventStore")
 * @ORM\Table(name="events")
 */
final class Message
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     */
    private UuidInterface $id;
    /**
     * @ORM\Column(type="string")
     */
    protected string $aggregateRootType;
    /**
     * @ORM\Column(type="uuid")
     */
    protected UuidInterface $aggregateRootId;
    /**
     * @ORM\Column(type="integer")
     */
    protected int $sequence;
    /**
     * @ORM\Column(type="date_immutable")
     */
    protected DateTimeImmutable $recordedAt;
    /**
     * @ORM\Column(type="string")
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
            $this->event = $this->eventType::fromArray($this->data);
        }

        return $this->event;
    }
}