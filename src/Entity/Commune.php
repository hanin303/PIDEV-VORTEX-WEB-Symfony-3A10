<?php

namespace App\Entity;

use App\Repository\CommuneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommuneRepository::class)]
class Commune
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_commune = null;

    #[ORM\Column(length: 255)]
    private ?string $long_alt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCommune(): ?string
    {
        return $this->nom_commune;
    }

    public function setNomCommune(string $nom_commune): self
    {
        $this->nom_commune = $nom_commune;

        return $this;
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
}
