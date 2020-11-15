<?php

namespace BlackFlag\Character;

use EventSourcing\EventStore;
use Exception;
use Ramsey\Uuid\UuidInterface;

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

    public function load(UuidInterface $characterId): Character
    {
        $stream = $this->eventStore->load($characterId);

        if (empty($stream)) {
            throw new Exception('Unable to find character');
        }

        return Character::load($characterId, $stream);
    }
}