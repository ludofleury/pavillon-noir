<?php

namespace Tests\EventSourcing;

use EventSourcing\Event;
use EventSourcing\Exception\InvalidSequenceException;
use EventSourcing\Message;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class MessageTest extends TestCase
{
    public function testHasAnUniqueIdentifier()
    {
        $event = new class() implements Event {
            static public function fromArray(array $data): Event
            {
            }

            public function toArray(): array
            {
                return [];
            }
        };

        $message = new Message('', UUID::uuid4(), 0, $event);
        $this->assertInstanceOf(UuidInterface::class, $message->getId());
    }

    public function testHasAggregateRootMetadata()
    {
        $event = new class() implements Event {
            static public function fromArray(array $data): Event
            {
            }

            public function toArray(): array
            {
                return [];
            }
        };

        $aggregateRootId = UUID::uuid4();
        $message = new Message('Test\Ar', $aggregateRootId, 0, $event);

        $this->assertEquals('Test\Ar', $message->getAggregateRootType());
        $this->assertEquals($aggregateRootId, $message->getAggregateRootId());
    }

    public function testIsSequenced()
    {
        $event = new class() implements Event {
            static public function fromArray(array $data): Event
            {
            }

            public function toArray(): array
            {
                return [];
            }
        };

        $message = new Message('', UUID::uuid4(), 0, $event);
        $this->assertEquals(0, $message->getSequence());
    }

    public function testAcceptsSequencingStartingAtZero()
    {
        $this->expectException(InvalidSequenceException::class);
        $this->expectExceptionMessage('Sequence cannot be negative (-1)');

        $event = new class() implements Event {
            static public function fromArray(array $data): Event
            {
            }

            public function toArray(): array
            {
                return [];
            }
        };

        new Message('', UUID::uuid4(), -1, $event);
    }

    public function testRecordsCreationTime()
    {
        $event = new class() implements Event {
            static public function fromArray(array $data): Event
            {
            }

            public function toArray(): array
            {
                return [];
            }
        };

        $now = (new \DateTimeImmutable())->getTimestamp();
        $message = new Message('', UUID::uuid4(), 0, $event);

        $oneSecondBefore = $now-1;
        $oneSecondAfter = $now+1;

        $this->assertGreaterThanOrEqual($oneSecondBefore, $message->getRecordedAt()->getTimestamp());
        $this->assertLessThanOrEqual($oneSecondAfter, $message->getRecordedAt()->getTimestamp());
    }

    public function testProvidesEventInstance()
    {
        $event = new class('event1') implements Event {
            private string $id;

            public function __construct(string $id)
            {
                $this->id = $id;
            }

            static public function fromArray(array $data): Event
            {
                return new self($data['id']);
            }

            public function toArray(): array
            {
                return ['id' => $this->id];
            }
        };

        $aggregateRootId = UUID::uuid4();
        $message = new Message('Test\Ar', $aggregateRootId, 0, $event);
        $this->assertEquals($event, $message->getEvent());
    }

    /**
     * Message is compliant with reflection hydration (for data-mapping ORM like doctrine)
     * Event is null & instantiated on-the-fly
     * @see Message::getEvent()
     */
    public function testInstantiatesEventFromNormalizedData()
    {
        $event = new class('event1') implements Event {
            private string $id;

            public function __construct(string $id)
            {
                $this->id = $id;
            }

            public function getId(): string
            {
                return $this->id;
            }

            static public function fromArray(array $data): Event
            {
                return new self($data['id']);
            }

            public function toArray(): array
            {
                return ['id' => $this->id];
            }
        };

        $aggregateRootId = UUID::uuid4();
        $message = new Message('Test\Ar', $aggregateRootId, 0, $event);

        $class = new \ReflectionClass($message);
        $property = $class->getProperty('event');
        $property->setAccessible(true);
        $property->setValue($message,null);

        $this->assertNull($property->getValue($message));
        $this->assertEquals($event, $message->getEvent());
        $this->assertEquals('event1', $event->getId());
    }

    public function testCachesEventAfterInstantiation()
    {
        $event = new class('event1') implements Event {
            private string $id;

            public function __construct(string $id)
            {
                $this->id = $id;
            }

            static public function fromArray(array $data): Event
            {
                return new self($data['id']);
            }

            public function toArray(): array
            {
                return ['id' => $this->id];
            }
        };

        $aggregateRootId = UUID::uuid4();
        $message = new Message('Test\Ar', $aggregateRootId, 0, $event);

        $class = new \ReflectionClass($message);
        $property = $class->getProperty('event');
        $property->setAccessible(true);
        $property->setValue($message,null);

        $this->assertNull($property->getValue($message));
        $message->getEvent();
        $this->assertNotNull($property->getValue($message));
    }
}
