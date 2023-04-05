<?php

namespace App\Entity;

use App\Repository\StationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StationRepository::class)]
class Station
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $long_alt = null;

    #[ORM\OneToMany(mappedBy: 'station', targetEntity: MoyenTransport::class)]
    private Collection $id_moy;

    public function __construct()
    {
        $this->id_moy = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongAlt(): ?string
    {
        return $this->long_alt;
    }

    public function setLongAlt(string $long_alt): self
    {
        $this->long_alt = $long_alt;

        return $this;
    }

    /**
     * @return Collection<int, MoyenTransport>
     */
    public function getIdMoy(): Collection
    {
        return $this->id_moy;
    }

    public function addIdMoy(MoyenTransport $idMoy): self
    {
        if (!$this->id_moy->contains($idMoy)) {
            $this->id_moy->add($idMoy);
            $idMoy->setStation($this);
        }

        return $this;
    }

    public function removeIdMoy(MoyenTransport $idMoy): self
    {
        if ($this->id_moy->removeElement($idMoy)) {
            // set the owning side to null (unless already changed)
            if ($idMoy->getStation() === $this) {
                $idMoy->setStation(null);
            }
        }

        return $this;
    }
}
