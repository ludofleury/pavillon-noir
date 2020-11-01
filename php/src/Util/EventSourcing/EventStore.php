<?php

namespace App\Util\EventSourcing;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class EventStore extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function append(Stream $stream): void
    {
        $manager = $this->getEntityManager();
        $connection = $this->getEntityManager()->getConnection();

        foreach ($stream as $event) {
            $manager->persist($event);
            $manager->flush();
        }
    }

    public function load(UuidInterface $aggregateRootId): Stream
    {
        $messages = $this->createQueryBuilder('e')
            ->where('e.aggregateRootId = :id')
            ->setParameter('id', $aggregateRootId)
            ->getQuery()
            ->getResult()
        ;
    }
}