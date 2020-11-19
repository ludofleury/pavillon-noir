<?php

namespace BlackFlag\Character\Concept\Event;

use EventSourcing\Event;

class SpentCharacteristicsPoints implements Event
{
    private string $characteristic;
    private int $points;

    public function __construct(string $characteristic, int $points)
    {
        $this->characteristic = $characteristic;
        $this->points = $points;
    }

    public function getCharacteristic(): string
    {
        return $this->characteristic;
    }

    public function getPoints(): int
    {
        return $this->points;
    }


    public function toArray(): array
    {
        return [
            'characteristic' => $this->characteristic,
            'points' => $this->points,
        ];
    }

    static public function fromArray(array $data): self
    {
        return new self(
            $data['characteristic'],
            $data['points'],
        );
    }
}
