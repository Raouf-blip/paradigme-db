<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name: 'praticien')]
class Praticien
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $id;

    #[ORM\Column(length: 48)]
    private string $nom;

    #[ORM\Column(length: 48)]
    private string $prenom;

    #[ORM\Column(length: 48)]
    private string $ville;

    #[ORM\Column(length: 128)]
    private string $email;

    #[ORM\Column(length: 24)]
    private string $telephone;

    #[ORM\ManyToOne(targetEntity: Specialite::class, inversedBy: 'praticiens')]
    #[ORM\JoinColumn(nullable: false)]
    private Specialite $specialite;

    #[ORM\ManyToOne(targetEntity: Structure::class, inversedBy: 'praticiens')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Structure $structure = null;

    #[ORM\ManyToMany(targetEntity: MotifVisite::class)]
    #[ORM\JoinTable(
        name: 'praticien2motif',
        joinColumns: [
            new ORM\JoinColumn(name: 'praticien_id', referencedColumnName: 'id')
        ],
        inverseJoinColumns: [
            new ORM\JoinColumn(name: 'motif_id', referencedColumnName: 'id')
        ]
    )]
    private Collection $motifs;

    #[ORM\ManyToMany(targetEntity: MoyenPaiement::class)]
    #[ORM\JoinTable(
        name: 'praticien2moyen',
        joinColumns: [
            new ORM\JoinColumn(name: 'praticien_id', referencedColumnName: 'id')
        ],
        inverseJoinColumns: [
            new ORM\JoinColumn(name: 'moyen_id', referencedColumnName: 'id')
        ]
    )]
    private Collection $moyensPaiement;

    public function __construct()
    {
        $this->motifs = new ArrayCollection();
        $this->moyensPaiement = new ArrayCollection();
    }

    public function getId(): string { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getVille(): string { return $this->ville; }
    public function getEmail(): string { return $this->email; }
    public function getTelephone(): string { return $this->telephone; }
    public function getSpecialite(): Specialite { return $this->specialite; }
    public function getStructure(): ?Structure { return $this->structure; }
    public function getMotifs(): Collection { return $this->motifs; }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }
    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function setSpecialite(Specialite $specialite): self
    {
        $this->specialite = $specialite;
        return $this;
    }

    public function setStructure(?Structure $structure): self
    {
        $this->structure = $structure;
        return $this;
    }

    public function addMotif(MotifVisite $motif): self
    {
        if (!$this->motifs->contains($motif)) {
            $this->motifs->add($motif);
        }
        return $this;
    }

    public function removeMotif(MotifVisite $motif): self
    {
        $this->motifs->removeElement($motif);
        return $this;
    }

    public function addMoyenPaiement(MoyenPaiement $moyen): self
    {
        if (!$this->moyensPaiement->contains($moyen)) {
            $this->moyensPaiement->add($moyen);
        }
        return $this;
    }

    public function removeMoyenPaiement(MoyenPaiement $moyen): self
    {
        $this->moyensPaiement->removeElement($moyen);
        return $this;
    }

}