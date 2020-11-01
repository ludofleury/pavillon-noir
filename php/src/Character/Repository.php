<?php

namespace App\Character;

use Exception;
use App\Util\EventSourcing\EventStore;
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
        $stream =$this->eventStore->load($characterId);

        if (empty($stream)) {
            throw new Exception('Unable to find character');
        }

        $character = Character::load($characterId, $stream);

        return $character;
    }
}