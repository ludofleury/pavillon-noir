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
class Event
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     */
    private UuidInterface $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $sequence;

    /**
     * @ORM\Column(type="json")
     */
    protected array $data;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private DateTimeImmutable $recordedAt;

    public function __construct(int $sequence, array $data)
    {
        $this->id = Uuid::uuid1();
        $this->sequence = $sequence;
        $this->recordedAt = new DateTimeImmutable();
        $this->data = $data;
    }
}