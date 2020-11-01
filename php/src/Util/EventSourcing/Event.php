<?php

namespace App\Util\EventSourcing;

interface Event
{
    public function toArray(): array;

    static public function fromArray(array $data): self;
}