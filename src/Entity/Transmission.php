<?php

namespace App\Entity;

use App\Repository\TransmissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransmissionRepository::class)]
class Transmission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $number = null;

    /**
     * @var Collection<int, Velo>
     */
    #[ORM\ManyToMany(targetEntity: Velo::class, inversedBy: 'transmissions')]
    private Collection $velos;

    public function __construct()
    {
        $this->velos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return Collection<int, Velo>
     */
    public function getVelos(): Collection
    {
        return $this->velos;
    }

    public function addVelo(Velo $velo): static
    {
        if (!$this->velos->contains($velo)) {
            $this->velos->add($velo);
        }

        return $this;
    }

    public function removeVelo(Velo $velo): static
    {
        $this->velos->removeElement($velo);

        return $this;
    }
}
