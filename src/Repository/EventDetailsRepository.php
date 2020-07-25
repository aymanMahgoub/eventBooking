<?php

namespace App\Repository;

use App\Entity\Employee;
use App\Entity\Event;
use App\Entity\EventDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Expr\Join;
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

    /**
     * @param array $criteria
     *
     * @return array
     */
    public function search(array $criteria)
    {
        $defaults     = [
            'employeeName' => null,
            'eventName'    => null,
            'fromDate'     => null,
            'toDate'       => null,
        ];
        $criteria     = array_merge(
            $defaults,
            $criteria
        );
        $queryBuilder = $this->createQueryBuilder('details');
        $query        = $queryBuilder->select('details');
        if ($criteria['employeeName'] !== null) {
            $query->innerJoin(Employee::class, 'employee', Join::WITH, 'details.employee = employee.id')
                ->andWhere(
                    $queryBuilder->expr()->eq('employee.name', ':employeeName')
                )
                ->setParameter('employeeName', $criteria['employeeName']);
        }
        if ($criteria['eventName'] !== null) {
            $query->innerJoin(Event::class, 'event', Join::WITH, 'details.event = event.id')
                ->andWhere(
                    $queryBuilder->expr()->eq('event.name', ':eventName')
                )
                ->setParameter('eventName', $criteria['eventName']);
        }
        if ($criteria['fromDate'] !== null) {
            $query->andWhere(
                $queryBuilder->expr()->gte('details.date', ':fromDate')
            )
                ->setParameter('fromDate', $criteria['fromDate']);
        }
        if ($criteria['toDate'] !== null) {
            $query->andWhere(
                $queryBuilder->expr()->lte('details.date', ':toDate')
            )
                ->setParameter('toDate', $criteria['toDate']);
        }

        return $query->getQuery()->getResult();
    }

}
