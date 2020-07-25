<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=EventDetails::class, mappedBy="event")
     */
    private $eventDetails;

    public function __construct()
    {
        $this->eventDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|EventDetails[]
     */
    public function getEventDetails(): Collection
    {
        return $this->eventDetails;
    }

    public function addEventDetail(EventDetails $eventDetail): self
    {
        if (!$this->eventDetails->contains($eventDetail)) {
            $this->eventDetails[] = $eventDetail;
            $eventDetail->setEvent($this);
        }

        return $this;
    }

    public function removeEventDetail(EventDetails $eventDetail): self
    {
        if ($this->eventDetails->contains($eventDetail)) {
            $this->eventDetails->removeElement($eventDetail);
            // set the owning side to null (unless already changed)
            if ($eventDetail->getEvent() === $this) {
                $eventDetail->setEvent(null);
            }
        }

        return $this;
    }
}
