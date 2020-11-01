<?php

namespace App\Util\EventSourcing;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EventStore extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function save(Stream $stream)
    {
        $manager = $this->getEntityManager();
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();

        try {

            foreach ($stream as $event) {
                $manager->persist($event);
            }

            $manager->flush();

            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollBack();
        }
    }

    public function load(): Stream
    {

    }
}