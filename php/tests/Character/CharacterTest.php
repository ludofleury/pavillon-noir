<?php

namespace App\Tests\Character;

use App\Character\Character;
use App\Character\Event\CharacterCreated;
use PHPUnit\Framework\TestCase;

final class CharacterTest extends TestCase
{
    public function testCreation(): void
    {
        $john = Character::create('John', 'Doe', 'Black beard', 35, true);
        $stream = $john->getUncommittedEvents();

        $this->assertCount(1, $stream);

        $creationEvent = $stream[0];

        $this->assertInstanceOf(CharacterCreated::class, $creationEvent);
        $this->assertEquals('John', $creationEvent->getFirstname());
        $this->assertEquals('Doe', $creationEvent->getLastname());
        $this->assertEquals('Black beard', $creationEvent->getNickname());
        $this->assertEquals(35, $creationEvent->getAge());
        $this->assertTrue($creationEvent->getGender());
    }
}