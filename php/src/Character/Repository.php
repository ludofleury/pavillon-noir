<?php

namespace App\Character;

use App\Util\EventSourcing\EventStore;

class Repository
{
    private EventStore $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function save(Character $character)
    {
        $stream = $character->getUncommittedEvents();
        $this->eventStore->append($stream);
    }
}