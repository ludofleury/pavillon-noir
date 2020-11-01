<?php

namespace App\Util\EventSourcing;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Util\EventSourcing\EventStore")
 * @ORM\Table(name="events")
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     */
    private UuidInterface $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $aggregateRootType;

    /**
     * @ORM\Column(type="uuid")
     */
    private UuidInterface $aggregateRootId;

    /**
     * @ORM\Column(type="integer")
     */
    private int $sequence;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private DateTimeImmutable $recordedAt;

    /**
     * @ORM\Column(type="string")
     */
    private string $eventType;

    /**
     * @ORM\Column(type="json")
     */
    protected array $data;

    public function __construct(string $aggregateRootType, UuidInterface $aggregateRootId, $sequence, Event $event)
    {
        $this->id = Uuid::uuid1();
        $this->aggregateRootType = $aggregateRootType;
        $this->aggregateRootId = $aggregateRootId;
        $this->sequence = $sequence;
        $this->recordedAt = new DateTimeImmutable();
        $this->eventType = get_class($event);
        $this->data = $event->toArray();
    }

    public function getEvent(): Event
    {
        $this->eventType::fromArray($this->data);
    }
}