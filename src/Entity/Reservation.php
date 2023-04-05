<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_reservation = null;

    #[ORM\Column(length: 255)]
    private ?string $heure_depart = null;

    #[ORM\Column(length: 255)]
    private ?string $heure_arrive = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(length: 255)]
    private ?string $type_ticket = null;

    #[ORM\ManyToOne(inversedBy: 'id_reservation')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $id_client = null;

    #[ORM\ManyToOne(inversedBy: 'id_reservation')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MoyenTransport $id_moy = null;

    #[ORM\ManyToOne(inversedBy: 'id_reservation')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Iteneraire $id_it = null;

    #[ORM\OneToOne(mappedBy: 'id_reservation', cascade: ['persist', 'remove'])]
    private ?Ticket $id_ticket = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->date_reservation;
    }

    public function setDateReservation(\DateTimeInterface $date_reservation): self
    {
        $this->date_reservation = $date_reservation;

        return $this;
    }

    public function getHeureDepart(): ?string
    {
        return $this->heure_depart;
    }

    public function setHeureDepart(string $heure_depart): self
    {
        $this->heure_depart = $heure_depart;

        return $this;
    }

    public function getHeureArrive(): ?string
    {
        return $this->heure_arrive;
    }

    public function setHeureArrive(string $heure_arrive): self
    {
        $this->heure_arrive = $heure_arrive;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTypeTicket(): ?string
    {
        return $this->type_ticket;
    }

    public function setTypeTicket(string $type_ticket): self
    {
        $this->type_ticket = $type_ticket;

        return $this;
    }

    public function getIdClient(): ?User
    {
        return $this->id_client;
    }

    public function setIdClient(?User $id_client): self
    {
        $this->id_client = $id_client;

        return $this;
    }

    

    public function getIdIt(): ?Iteneraire
    {
        return $this->id_it;
    }

    public function setIdIt(?Iteneraire $id_it): self
    {
        $this->id_it = $id_it;

        return $this;
    }

    public function getIdMoy(): ?MoyenTransport
    {
        return $this->id_moy;
    }

    public function setIdMoy(?MoyenTransport $id_moy): self
    {
        $this->id_moy = $id_moy;

        return $this;
    }

    public function getIdTicket(): ?Ticket
    {
        return $this->id_ticket;
    }

    public function setIdTicket(Ticket $id_ticket): self
    {
        // set the owning side of the relation if necessary
        if ($id_ticket->getIdReservation() !== $this) {
            $id_ticket->setIdReservation($this);
        }

        $this->id_ticket = $id_ticket;

        return $this;
    }
}
