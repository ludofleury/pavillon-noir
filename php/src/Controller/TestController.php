<?php

namespace App\Controller;

use App\Character\Character;
use App\Util\EventSourcing\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class TestController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/character")
     */
    public function number(): Response
    {
       $character = Character::create('Jane', 'Doe', 'Bloody Lady', 20, false);

       $this->em->getRepository(Message::class)->save($character->getUncommittedEvents());
    }
}