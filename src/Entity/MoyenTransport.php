<?php

namespace App\Entity;

use App\Repository\MoyenTransportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoyenTransportRepository::class)]
class MoyenTransport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $matricule = null;

    #[ORM\Column]
    private ?int $num = null;

    #[ORM\Column]
    private ?int $capacite = null;

    #[ORM\Column(length: 255)]
    private ?string $type_vehicule = null;

    #[ORM\Column(length: 255)]
    private ?string $marque = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\ManyToOne(inversedBy: 'id_moy')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ligne $id_ligne = null;

    #[ORM\ManyToOne(inversedBy: 'id_moy')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Station $station = null;

    #[ORM\OneToMany(mappedBy: 'id_moy', targetEntity: Reservation::class)]
    private Collection $id_reservation;

    public function __construct()
    {
        $this->id_res = new ArrayCollection();
        $this->id_reservation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?int
    {
        return $this->matricule;
    }

    public function setMatricule(int $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): self
    {
        $this->num = $num;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getTypeVehicule(): ?string
    {
        return $this->type_vehicule;
    }

    public function setTypeVehicule(string $type_vehicule): self
    {
        $this->type_vehicule = $type_vehicule;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getIdLigne(): ?Ligne
    {
        return $this->id_ligne;
    }

    public function setIdLigne(?Ligne $id_ligne): self
    {
        $this->id_ligne = $id_ligne;

        return $this;
    }

    public function getStation(): ?Station
    {
        return $this->station;
    }

    public function setStation(?Station $station): self
    {
        $this->station = $station;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getIdRes(): Collection
    {
        return $this->id_res;
    }

    public function addIdRe(Reservation $idRe): self
    {
        if (!$this->id_res->contains($idRe)) {
            $this->id_res->add($idRe);
            $idRe->setIdMoyen($this);
        }

        return $this;
    }

    public function removeIdRe(Reservation $idRe): self
    {
        if ($this->id_res->removeElement($idRe)) {
            // set the owning side to null (unless already changed)
            if ($idRe->getIdMoyen() === $this) {
                $idRe->setIdMoyen(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getIdReservation(): Collection
    {
        return $this->id_reservation;
    }

    public function addIdReservation(Reservation $idReservation): self
    {
        if (!$this->id_reservation->contains($idReservation)) {
            $this->id_reservation->add($idReservation);
            $idReservation->setIdMoy($this);
        }

        return $this;
    }

    public function removeIdReservation(Reservation $idReservation): self
    {
        if ($this->id_reservation->removeElement($idReservation)) {
            // set the owning side to null (unless already changed)
            if ($idReservation->getIdMoy() === $this) {
                $idReservation->setIdMoy(null);
            }
        }

        return $this;
    }
}
