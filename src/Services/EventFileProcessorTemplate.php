<?php

namespace App\Services;

use App\Entity\Employee;
use App\Entity\Event;
use App\Entity\EventDetails;

/**
 * Class EventFileProcessorTemplate
 *
 * @package App\Services
 */
abstract class EventFileProcessorTemplate
{
    /**
     * @param array $eventData
     *
     * @return EventDetails
     */
    public function processEventData(array $eventData): EventDetails
    {
        $employee = $this->getOrCreateEmployee($eventData);
        $event    = $this->getOrCreateEvent($eventData);
        $this->addEventDetailsIfNotExist($employee, $event, $eventData);

    }

    /**
     * @param Employee $employee
     * @param Event    $event
     * @param array    $eventData
     *
     * @return EventDetails
     */
    abstract protected function addEventDetailsIfNotExist(
        Employee $employee,
        Event $event,
        array $eventData
    ): EventDetails;

    /**
     * @param array $eventData
     *
     * @return Employee
     */
    abstract protected function getOrCreateEmployee(array $eventData): Employee;

    /**
     * @param array $eventData
     *
     * @return Event
     */
    abstract protected function getOrCreateEvent(array $eventData): Event;
}