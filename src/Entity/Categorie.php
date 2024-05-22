<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
#[UniqueEntity(fields: ['name'], message: 'Cet article existe déjà')]
#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[Vich\Uploadable]
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
    #[OrderBy(['name' => 'ASC'])]
    private Collection $velos;

#[Vich\UploadableField(mapping: 'categories_image', fileNameProperty: 'imageName', size: 'imageSize')]
private ?File $imageFile = null;

#[ORM\Column(length: 255)]
private ?string $imageName = null;

#[ORM\Column]
private ?int $imageSize = null;

#[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

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

public function setImageFile(?File $imageFile = null): void
{
  $this->imageFile = $imageFile;

  if (null !== $imageFile) {
    // Il faut biensur que la propriété updatedAt soit crée sur l'Entity.
    $this->updatedAt = new \DateTimeImmutable();
  }
}

public function getImageFile(): ?File
{
  return $this->imageFile;
}

public function setImageName(?string $imageName): void
{
  $this->imageName = $imageName;
}

public function getImageName(): ?string
{
  return $this->imageName;
}

public function setImageSize(?int $imageSize): void
{
  $this->imageSize = $imageSize;
}

public function getImageSize(): ?int
{
  return $this->imageSize;
}

public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
