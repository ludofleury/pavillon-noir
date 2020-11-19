<?php

namespace BlackFlag\Character\Concept\Event;

use EventSourcing\Event;

class SpentExtraCharacteristicPoint implements Event
{
    private int $extraPointIndex;
    private string $value;

    public function __construct(int $extraPointIndex, string $value)
    {
        $this->extraPointIndex = $extraPointIndex;
        $this->value = $value;
    }

    public function getExtraPointIndex(): int
    {
        return $this->extraPointIndex;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return [
            'extraPointIndex' => $this->extraPointIndex,
            'value' => $this->value,
        ];
    }

    static public function fromArray(array $data): self
    {
        return new self(
            $data['extraPointIndex'],
            $data['value'],
        );
    }
}
