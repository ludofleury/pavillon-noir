<?php

namespace Tests\EventSourcing;

use EventSourcing\AggregateRoot;
use EventSourcing\ChildEntity;
use EventSourcing\Event;
use EventSourcing\Message;
use EventSourcing\Stream;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ChildEntityTest extends TestCase
{
    public function testDelegatesImmediatelyEventToAggregateRoot()
    {
        $ar = new class(Uuid::uuid4()) extends AggregateRoot
        {
            public function applyChildEntityTestMarkerEvent(ChildEntityTestMarkerEvent $event)
            {
                $event->markApply('1');
            }
        };

        $child = new class($ar) extends ChildEntity
        {
            public function test()
            {
                $this->apply(new ChildEntityTestMarkerEvent());
            }

            public function applyChildEntityTestMarkerEvent(ChildEntityTestMarkerEvent $event)
            {
                $event->markApply('2');
            }
        };

        $child->test();

        $stream = $ar->getUncommittedEvents();
        $event = array_map(
            function (Message $message) { return $message->getEvent();},
            iterator_to_array($stream)
        )[0];

        $this->assertInstanceOf(ChildEntityTestMarkerEvent::class, $event);
        $this->assertEquals(
            '12',
            $event->getWitness()
        );
    }
}

class ChildEntityTestMarkerEvent implements Event
{
    private string $witness = '';

    public function markApply(string $marker): void
    {
        $this->witness .= $marker;
    }

    public function getWitness(): string
    {
        return $this->witness;
    }

    static public function fromArray(array $data): DummyEvent
    {
        return new self();
    }

    public function toArray(): array
    {
        return [];
    }
}
