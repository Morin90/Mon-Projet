<?php

namespace App\Entity;

use App\Repository\FrameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FrameRepository::class)]
class Frame
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $size = null;

    /**
     * @var Collection<int, Velo>
     */
    #[ORM\ManyToMany(targetEntity: Velo::class, inversedBy: 'frames')]
    private Collection $velos;

    public function __construct()
    {
        $this->velos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): static
    {
        $this->size = $size;

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
