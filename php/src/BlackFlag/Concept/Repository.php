<?php

namespace BlackFlag\Concept;

use Exception;
use EventSourcing\EventStore;
use Ramsey\Uuid\UuidInterface;

class Repository
{
    private EventStore $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function save(Concept $concept)
    {
        $stream = $concept->getUncommittedEvents();
        $this->eventStore->append($stream);
    }

    public function load(UuidInterface $conceptId): Concept
    {
        $stream = $this->eventStore->load($conceptId);

        if (empty($stream)) {
            throw new Exception('Unable to find Concept');
        }

        return Concept::load($conceptId, $stream);
    }
}