<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'motif_visite')]
class MotifVisite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private string $libelle;

    #[ORM\ManyToOne(targetEntity: Specialite::class, inversedBy: 'motifs')]
    #[ORM\JoinColumn(nullable: false)]
    private Specialite $specialite;

    public function getId(): ?int { return $this->id; }
    public function getLibelle(): string { return $this->libelle; }
    public function getSpecialite(): Specialite { return $this->specialite; }
}