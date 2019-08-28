<?php

namespace App\Entity;

use App\Validator as LouvreAssert;
use Doctrine\Common\Annotations\Annotation\Target;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 * @LouvreAssert\ThousandTicketsReached()
 *
 */
class Booking
{
    const TYPE_DAY = 1;
    const TYPE_HALF_DAY = 2;
    const MAX_TICKETS = 20;


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $orderDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Range(
     *      min = "now",
     *      max = "+1 year"
     * )
     * @Assert\NotNull()
     * @LouvreAssert\NotTuesday()
     * @LouvreAssert\NotSunday()
     */
    private $visitDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $ticketNumber;

    /**
     * @ORM\Column(type="integer")
     */
    private $visitType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="float")
     */
    private $totalPrice;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $orderCode;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="booking" ,cascade={"persist"})
     * @Assert\Valid()
     */
    private $tickets;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getVisitDate(): ?\DateTime
    {
        return $this->visitDate;
    }

    public function setVisitDate(\DateTimeInterface $visitDate): self
    {
        $this->visitDate = $visitDate;

        return $this;
    }

    public function getTicketNumber(): ?int
    {
        return $this->ticketNumber;
    }

    public function setTicketNumber(int $ticketNumber): self
    {
        $this->ticketNumber = $ticketNumber;

        return $this;
    }

    public function getVisitType(): ?int
    {
        return $this->visitType;
    }

    public function setVisitType(int $visitType): self
    {
        $this->visitType = $visitType;

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

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getOrderCode(): ?string
    {
        return $this->orderCode;
    }

    public function setOrderCode(string $orderCode): self
    {
        $this->orderCode = $orderCode;

        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setBooking($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getBooking() === $this) {
                $ticket->setBooking(null);
            }
        }

        return $this;
    }
}
