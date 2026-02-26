<?php

namespace App\Entity;

use App\Repository\ResultatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultatRepository::class)]
class Resultat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $nombre = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $unite = null;

    #[ORM\Column(nullable: true)]
    private ?int $prixUnitaire = null;

    #[ORM\Column(nullable: true)]
    private ?string $delaiProduction = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $explication = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?int
    {
        return $this->nombre;
    }

    public function setNombre(?int $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(?string $unite): static
    {
        $this->unite = $unite;

        return $this;
    }

    public function getPrixUnitaire(): ?int
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(?int $prixUnitaire): static
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getDelaiProduction(): ?string
    {
        return $this->delaiProduction;
    }

    public function setDelaiProduction(?string $delaiProduction): static
    {
        $this->delaiProduction = $delaiProduction;

        return $this;
    }

    public function getExplication(): ?string
    {
        return $this->explication;
    }

    public function setExplication(?string $explication): static
    {
        $this->explication = $explication;

        return $this;
    }
}
