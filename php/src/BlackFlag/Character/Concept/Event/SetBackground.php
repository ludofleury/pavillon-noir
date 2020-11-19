<?php

namespace BlackFlag\Character\Concept\Event;

use EventSourcing\Event;

class SetBackground implements Event
{
    private string $background;

    public function __construct(string $background)
    {
        $this->background = $background;
    }

    public function getBackground(): string
    {
        return $this->background;
    }

    public function toArray(): array
    {
        return [
            'background' => $this->background,
        ];
    }

    static public function fromArray(array $data): self
    {
        return new self(
            $data['background'],
        );
    }

}