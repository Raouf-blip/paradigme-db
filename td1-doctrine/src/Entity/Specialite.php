<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'specialite')]
class Specialite
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(length: 48)]
    private string $libelle;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(targetEntity: Praticien::class, mappedBy: 'specialite')]
    private Collection $praticiens;

    #[ORM\OneToMany(targetEntity: MotifVisite::class, mappedBy: 'specialite')]
    private Collection $motifs;

    public function __construct()
    {
        $this->praticiens = new ArrayCollection();
        $this->motifs = new ArrayCollection();
    }

    public function getId(): int { return $this->id; }
    public function getLibelle(): string { return $this->libelle; }
    public function getDescription(): ?string { return $this->description; }

    public function getPraticiens(): Collection { return $this->praticiens; }
    public function getMotifs(): Collection { return $this->motifs; }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;
        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }
}
