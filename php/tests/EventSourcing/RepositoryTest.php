<?php

namespace Tests\EventSourcing;

use EventSourcing\AggregateRoot;
use EventSourcing\Event;
use EventSourcing\EventStore;
use EventSourcing\EventBus;
use EventSourcing\Message;
use EventSourcing\Repository;
use EventSourcing\Stream;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class RepositoryTest extends TestCase
{
    public function testSavesAggregateRoot()
    {
        $store = $this->getMockForAbstractClass(EventStore::class);
        $bus = $this->getMockForAbstractClass(EventBus::class);

        $id = $id = Uuid::uuid4();
        $ar = new class($id) extends AggregateRoot{};

        $repository = new class(get_class($ar), $store, $bus) extends Repository
        {
            public function __construct(string $aggregateRootType, EventStore $eventStore, EventBus $eventBus)
            {
                parent::__construct($aggregateRootType, $eventStore, $eventBus);
            }
        };

        $store->expects($this->once())
            ->method('append')
            ->with($this->isInstanceOf(Stream::class))
        ;

        $bus->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(Stream::class))
        ;

        $repository->save($ar);
    }
}