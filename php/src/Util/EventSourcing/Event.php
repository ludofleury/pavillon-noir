<?php

namespace App\Util\EventSourcing;

use JsonSerializable;
use DateTimeImmutable;

abstract class Event implements JsonSerializable
{
    private string $id;

    private int $sequence;

    private array $data;

    private DateTimeImmutable $recordedAt;

    public function __construct(int $sequence, array $data)
    {
        $this->id = 1;
        $this->recordedAt = new DateTimeImmutable();
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'sequence' => $this->sequence,
            'data' => $this->data, // ->jsonSerialize
            'recordedAt' => $this->recordedAt
        ];
    }
}