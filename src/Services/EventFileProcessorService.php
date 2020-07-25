<?php

namespace App\Services;

use App\Constant\EventConstant;
use App\Entity\Employee;
use App\Entity\Event;
use App\Entity\EventDetails;
use App\Repository\EmployeeRepository;
use App\Repository\EventDetailsRepository;
use App\Repository\EventRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class EventFileProcessorService
 *
 * @package App\Services
 */
class EventFileProcessorService
{
    /** @var EmployeeRepository $employeeRepository */
    private $employeeRepository;

    /** @var EventRepository $eventRepository */
    private $eventRepository;

    /** @var EventDetailsRepository $eventDetailsRepository */
    private $eventDetailsRepository;

    /**
     * EventFileProcessorService constructor.
     *
     * @param EventDetailsRepository $eventDetailsRepository
     * @param EmployeeRepository     $employeeRepository
     * @param EventRepository        $eventRepository
     */
    public function __construct(
        EventDetailsRepository $eventDetailsRepository,
        EmployeeRepository $employeeRepository,
        EventRepository $eventRepository
    ) {
        $this->eventDetailsRepository = $eventDetailsRepository;
        $this->employeeRepository     = $employeeRepository;
        $this->eventRepository        = $eventRepository;
    }

    /**
     * @param array $eventsData
     *
     * @return EventDetails
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function processEventData(array $eventsData): EventDetails
    {
        foreach ($eventsData as $eventData) {
            $employee = $this->getOrCreateEmployee($eventData);
            $event    = $this->getOrCreateEvent($eventData);
            $this->addEventDetailsIfNotExist($employee, $event, $eventData);
        }
    }

    /**
     * @param Employee $employee
     * @param Event    $event
     * @param array    $eventData
     *
     * @return EventDetails
     * @throws ORMException
     * @throws OptimisticLockException
     */
    private function addEventDetailsIfNotExist(
        Employee $employee,
        Event $event,
        array $eventData
    ): EventDetails {
        $eventDetails = $this->eventDetailsRepository->findOneBy(
            [
                'employee' => $employee,
                'event'    => $event,
                'fee'      => $eventData[EventConstant::FEE],
                'date'     => $eventData[EventConstant::EVENT_DATE],
            ]
        );
        if ($eventDetails !== null && $eventDetails instanceof EventDetails) {
            return $eventDetails;
        }
        $eventDetails = new EventDetails();
        $eventDetails->setEmployee($employee);
        $eventDetails->setEvent($event);
        $eventDetails->setFee($eventData[EventConstant::FEE]);
        $eventDetails->setDate($eventData[EventConstant::EVENT_DATE]);
        $this->eventDetailsRepository->save($eventDetails);

        return $eventDetails;
    }

    /**
     * @param array $eventData
     *
     * @return Employee
     * @throws ORMException
     * @throws OptimisticLockException
     */
    private function getOrCreateEmployee(array $eventData): Employee
    {
        $employee = $this->employeeRepository->findOneBy(
            [
                'email' => $eventData[EventConstant::EMPLOYEE_MAIL],
            ]
        );
        if ($employee !== null && $employee instanceof Employee) {

            return $employee;
        }
        $employee = new Employee();
        $employee->setName($eventData[EventConstant::EMPLOYEE_NAME]);
        $employee->setEmail($eventData[EventConstant::EMPLOYEE_MAIL]);
        $this->employeeRepository->save($employee);

        return $employee;
    }

    /**
     * @param array $eventData
     *
     * @return Event
     * @throws ORMException
     * @throws OptimisticLockException
     */
    private function getOrCreateEvent(array $eventData): Event
    {

        $event = $this->eventRepository->find($eventData[EventConstant::EVENT_ID]);
        if ($event !== null && $event instanceof Event) {

            return $event;
        }
        $event = new Event();
        $event->setName($eventData[EventConstant::EVENT_NAME]);
        $event->setId($eventData[EventConstant::EVENT_ID]);
        $this->eventRepository->save($event);

        return $event;
    }

}
