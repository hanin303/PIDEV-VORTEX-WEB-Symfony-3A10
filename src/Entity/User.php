<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $mdp = null;

    #[ORM\Column]
    private ?int $num_tel = null;

    #[ORM\Column]
    private ?int $CIN = null;

    #[ORM\Column(length: 255 , nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'id_user')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $id_role = null;

    #[ORM\OneToMany(mappedBy: 'id_user', targetEntity: Annonces::class)]
    private Collection $id_annonce;

    #[ORM\OneToMany(mappedBy: 'id_client', targetEntity: Reservation::class)]
    private Collection $id_reservation;

    #[ORM\ManyToOne(inversedBy: 'id_user')]
    #[ORM\JoinColumn(nullable: true)]
    private ?UserState $id_state = null;

    public function __construct()
    {
        $this->id_annonce = new ArrayCollection();
        $this->id_reservation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getNumTel(): ?int
    {
        return $this->num_tel;
    }

    public function setNumTel(int $num_tel): self
    {
        $this->num_tel = $num_tel;

        return $this;
    }

    public function getCIN(): ?int
    {
        return $this->CIN;
    }

    public function setCIN(int $CIN): self
    {
        $this->CIN = $CIN;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getIdRole(): ?Role
    {
        return $this->id_role;
    }

    public function setIdRole(?Role $id_role): self
    {
        $this->id_role = $id_role;

        return $this;
    }

    /**
     * @return Collection<int, Annonces>
     */
    public function getIdAnnonce(): Collection
    {
        return $this->id_annonce;
    }

    public function addIdAnnonce(Annonces $idAnnonce): self
    {
        if (!$this->id_annonce->contains($idAnnonce)) {
            $this->id_annonce->add($idAnnonce);
            $idAnnonce->setIdUser($this);
        }

        return $this;
    }

    public function removeIdAnnonce(Annonces $idAnnonce): self
    {
        if ($this->id_annonce->removeElement($idAnnonce)) {
            // set the owning side to null (unless already changed)
            if ($idAnnonce->getIdUser() === $this) {
                $idAnnonce->setIdUser(null);
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
            $idReservation->setIdClient($this);
        }

        return $this;
    }

    public function removeIdReservation(Reservation $idReservation): self
    {
        if ($this->id_reservation->removeElement($idReservation)) {
            // set the owning side to null (unless already changed)
            if ($idReservation->getIdClient() === $this) {
                $idReservation->setIdClient(null);
            }
        }

        return $this;
    }

    public function getIdState(): ?UserState
    {
        return $this->id_state;
    }

    public function setIdState(?UserState $id_state): self
    {
        $this->id_state = $id_state;

        return $this;
    }
}
