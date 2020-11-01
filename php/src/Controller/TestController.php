<?php

namespace App\Controller;

use App\Character\Character;
use App\Character\Repository;
use App\Util\EventSourcing\EventStore;
use App\Util\EventSourcing\Message;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\EventManager\Event;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class TestController
{
    public function __construct(EventStore $es)
    {
        $this->es = $es;
    }

    /**
     * @Route("/character")
     */
    public function number(): Response
    {
       $character = Character::create('Jane', 'Doe', 'Bloody Lady', 20, false);

       $repository = new Repository($this->es);
       $repository->save($character);
    }
}