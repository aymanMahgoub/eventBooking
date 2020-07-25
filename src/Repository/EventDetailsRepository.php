<?php

namespace App\Repository;

use App\Entity\EventDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventDetails[]    findAll()
 * @method EventDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventDetails::class);
    }

    /**
     * @param EventDetails $eventDetails
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(EventDetails $eventDetails)
    {
        $this->_em->persist($eventDetails);
        $this->_em->flush();
    }

}
