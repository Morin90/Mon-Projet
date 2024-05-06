<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
#[UniqueEntity(fields: ['name'], message: 'Cet article existe déjà')]
#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 50)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $description = null;

    /**
     * @var Collection<int, Velo>
     */
    #[ORM\OneToMany(targetEntity: Velo::class, mappedBy: 'categorie')]
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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
            $velo->setCategorie($this);
        }

        return $this;
    }

    public function removeVelo(Velo $velo): static
    {
        if ($this->velos->removeElement($velo)) {
            // set the owning side to null (unless already changed)
            if ($velo->getCategorie() === $this) {
                $velo->setCategorie(null);
            }
        }

        return $this;
    }
}
