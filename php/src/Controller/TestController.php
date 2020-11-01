<?php

namespace App\Controller;

use App\Character\Character;
use App\Character\Repository;
use App\Util\EventSourcing\EventStore;
use App\Util\EventSourcing\Message;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\EventManager\Event;
use Ramsey\Uuid\Uuid;
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
     * @Route("/save")
     */
    public function save(): Response
    {
       $character = Character::create('John', 'Doe', 'Bloody Sir', 20, true);

       $repository = new Repository($this->es);
       $repository->save($character);

        return new Response();
    }

    /**
     * @Route("/load/{id}")
     */
    public function load(string $id): Response
    {
        $repository = new Repository($this->es);
        $character = $repository->load(Uuid::fromString($id));
        
        return new Response();
    }
}