<?php

namespace Tests\Controller;

use App\Repository\CharacterRepository;
use BlackFlag\Character\Character;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/test", name="app_test")
 */
class TestController
{
    public function __invoke(CharacterRepository $characterRepository): Response
    {
        $character = Character::create(
            'John',
            'Doe',
            'Black beard',
            35,
            true,
            [
                'adaptability' => 5,
                'charisma'     => 5,
                'constitution' => 5,
                'dexterity'    => 5,
                'expression'   => 5,
                'knowledge'    => 5,
                'perception'   => 5,
                'power'        => 5,
                'strength'     => 6,
            ]
        );
        $characterRepository->save($character);

        return new Response('<html><body>test</body></html>');
    }
}