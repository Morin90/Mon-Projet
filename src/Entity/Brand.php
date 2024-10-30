<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrandRepository::class)]
class Brand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    /**
     * @var Collection<int, Velo>
     */
    #[ORM\OneToMany(targetEntity: Velo::class, mappedBy: 'brand', orphanRemoval: true)]
    private Collection $velos;

    public function __construct()
    {
        $this->velos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $velo->setBrand($this);
        }

        return $this;
    }

    public function removeVelo(Velo $velo): static
    {
        if ($this->velos->removeElement($velo)) {
            // set the owning side to null (unless already changed)
            if ($velo->getBrand() === $this) {
                $velo->setBrand(null);
            }
        }

        return $this;
    }
}
