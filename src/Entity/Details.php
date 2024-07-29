<?php

namespace App\Entity;

use App\Repository\DetailsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailsRepository::class)]
class Details
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'details', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Velo $velo = null;

    #[ORM\Column]
    private ?string $taille = null;

    #[ORM\Column]
    private ?string $roues = null;

    #[ORM\Column]
    private ?int $vitesse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVelo(): ?Velo
    {
        return $this->velo;
    }

    public function setVelo(Velo $velo): static
    {
        $this->velo = $velo;

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): static
    {
        $this->taille = $taille;

        return $this;
    }

    public function getRoues(): ?string
    {
        return $this->roues;
    }

    public function setRoues(int $roues): static
    {
        $this->roues = $roues;

        return $this;
    }

    public function getVitesse(): ?int
    {
        return $this->vitesse;
    }

    public function setVitesse(int $vitesse): static
    {
        $this->vitesse = $vitesse;

        return $this;
    }
}
