<?php

namespace App\Util\EventSourcing;

abstract class AggregateRoot
{
    private $stream = [];

    private $sequence = -1;
}