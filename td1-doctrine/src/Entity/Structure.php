<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name: 'structure')]
class Structure
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $id;

    #[ORM\Column(length: 48)]
    private string $nom;

    #[ORM\OneToMany(mappedBy: 'structure', targetEntity: Praticien::class)]
    private Collection $praticiens;

    public function __construct()
    {
        $this->praticiens = new ArrayCollection();
    }

    public function getId(): string { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getPraticiens(): Collection { return $this->praticiens; }
}
