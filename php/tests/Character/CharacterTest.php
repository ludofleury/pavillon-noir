<?php

namespace App\Tests\Character;

use App\Character\Character;
use PHPUnit\Framework\TestCase;

final class CharacterTest extends TestCase
{
    public function testDummy(): void
    {
        $sut = new Character();
        $this->assertEquals(10, $sut->getHealth());
    }
}