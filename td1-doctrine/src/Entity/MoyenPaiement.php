<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'moyen_paiement')]
class MoyenPaiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private string $libelle;

    public function getId(): ?int { return $this->id; }
    public function getLibelle(): string { return $this->libelle; }
}
