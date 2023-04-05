<?php

namespace App\Entity;

use App\Repository\TrajetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrajetRepository::class)]
class Trajet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $temps_parcours = null;

    #[ORM\Column(length: 255)]
    private ?string $pts_depart = null;

    #[ORM\Column(length: 255)]
    private ?string $pts_arrive = null;

    #[ORM\ManyToOne(inversedBy: 'id_trajet')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Iteneraire $id_it = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTempsParcours(): ?string
    {
        return $this->temps_parcours;
    }

    public function setTempsParcours(string $temps_parcours): self
    {
        $this->temps_parcours = $temps_parcours;

        return $this;
    }

    public function getPtsDepart(): ?string
    {
        return $this->pts_depart;
    }

    public function setPtsDepart(string $pts_depart): self
    {
        $this->pts_depart = $pts_depart;

        return $this;
    }

    public function getPtsArrive(): ?string
    {
        return $this->pts_arrive;
    }

    public function setPtsArrive(string $pts_arrive): self
    {
        $this->pts_arrive = $pts_arrive;

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
}
