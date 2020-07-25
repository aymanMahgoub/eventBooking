<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 */
class Employee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=70)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=EventDetails::class, mappedBy="employee")
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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
            $eventDetail->setEmployee($this);
        }

        return $this;
    }

    public function removeEventDetail(EventDetails $eventDetail): self
    {
        if ($this->eventDetails->contains($eventDetail)) {
            $this->eventDetails->removeElement($eventDetail);
            // set the owning side to null (unless already changed)
            if ($eventDetail->getEmployee() === $this) {
                $eventDetail->setEmployee(null);
            }
        }

        return $this;
    }
}
