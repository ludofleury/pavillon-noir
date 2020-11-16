<?php

namespace BlackFlag\Character\Concept\Event;

use EventSourcing\Event;

class ConceptCreated implements Event
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return  [
            'name' => $this->name,
        ];
    }

    static public function fromArray(array $data): self
    {
        return new self(
            $data['name'],
        );
    }

}