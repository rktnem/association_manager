<?php

namespace App\Entity;

use App\Repository\AssociationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: AssociationRepository::class)]
class Association
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['association.list'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['association.list'])]
    private ?string $nom = null;

    #[ORM\Column(nullable: true)]
    private ?int $nombre_membre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $activite = null;

    #[ORM\ManyToOne(inversedBy: 'associations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['association.list'])]
    private ?Commune $commune = null;

    #[ORM\Column(length: 255)]
    #[Groups(['association.list'])]
    private ?string $nom_president = null;

    #[ORM\Column(length: 150)]
    private ?string $numero_recepisse = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Groups(['association.list'])]
    private ?string $contact = null;
    
    #[ORM\Column(length: 150, nullable: true)]
    private ?string $compte_bancaire = null;
    
    #[ORM\Column(length: 150, nullable: true)]
    private ?string $nif = null;
    
    #[ORM\Column(length: 150, nullable: true)]
    private ?string $stat = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\ManyToOne]
    private ?TypeAssociation $typeAssociation = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Projet $projet = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $keypass = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password = null;

    /**
     * @var Collection<int, Membre>
     */
    #[ORM\OneToMany(targetEntity: Membre::class, mappedBy: 'association')]
    private Collection $membres;

    public function __construct()
    {
        $this->membres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNombreMembre(): ?int
    {
        return $this->nombre_membre;
    }

    public function setNombreMembre(?int $nombre_membre): static
    {
        $this->nombre_membre = $nombre_membre;

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): static
    {
        $this->activite = $activite;

        return $this;
    }

    public function getCommune(): ?Commune
    {
        return $this->commune;
    }

    public function setCommune(?Commune $commune): static
    {
        $this->commune = $commune;

        return $this;
    }

    public function getNomPresident(): ?string
    {
        return $this->nom_president;
    }

    public function setNomPresident(string $nom_president): static
    {
        $this->nom_president = $nom_president;

        return $this;
    }

    public function getNumeroRecepisse(): ?string
    {
        return $this->numero_recepisse;
    }

    public function setNumeroRecepisse(string $numero_recepisse): static
    {
        $this->numero_recepisse = $numero_recepisse;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getCompteBancaire(): ?string
    {
        return $this->compte_bancaire;
    }

    public function setCompteBancaire(?string $compte_bancaire): static
    {
        $this->compte_bancaire = $compte_bancaire;

        return $this;
    }

    public function getNif(): ?string
    {
        return $this->nif;
    }

    public function setNif(?string $nif): static
    {
        $this->nif = $nif;

        return $this;
    }

    public function getStat(): ?string
    {
        return $this->stat;
    }

    public function setStat(?string $stat): static
    {
        $this->stat = $stat;

        return $this;
    }

    public function getTypeAssociation(): ?TypeAssociation
    {
        return $this->typeAssociation;
    }

    public function setTypeAssociation(?TypeAssociation $typeAssociation): static
    {
        $this->typeAssociation = $typeAssociation;

        return $this;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): static
    {
        $this->projet = $projet;

        return $this;
    }

    public function getKeypass(): ?string
    {
        return $this->keypass;
    }

    public function setKeypass(?string $keypass): static
    {
        $this->keypass = $keypass;

        return $this;
    }

    /**
     * @return Collection<int, Membre>
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Membre $membre): static
    {
        if (!$this->membres->contains($membre)) {
            $this->membres->add($membre);
            $membre->setAssociation($this);
        }

        return $this;
    }

    public function removeMembre(Membre $membre): static
    {
        if ($this->membres->removeElement($membre)) {
            // set the owning side to null (unless already changed)
            if ($membre->getAssociation() === $this) {
                $membre->setAssociation(null);
            }
        }

        return $this;
    }
}