<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\VeloRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: VeloRepository::class)]
#[UniqueEntity('name')]
#[Vich\Uploadable]
class Velo
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

    #[ORM\Column]
    #[Assert\NotNull]
    #[Assert\Positive]
    private ?float $prix = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'velos')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Categorie $categorie = null;

    #[Vich\UploadableField(mapping: 'velos_image', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\JoinColumn(nullable: true)]
    #[ORM\Column(length: 255)]
    private ?string $imageName = null;

    #[ORM\Column]
    private ?int $imageSize = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Notes>
     */
    #[ORM\OneToMany(targetEntity: Notes::class, mappedBy: 'velo', orphanRemoval: true)]
    private Collection $notes;

    /**
     * @var Collection<int, Frame>
     */
    #[ORM\ManyToMany(targetEntity: Frame::class, mappedBy: 'velos')]
    #[Assert\Count(min: 1, minMessage: 'Sélectionner au moins une taille de cadre')]
    private Collection $frames;

    /**
     * @var Collection<int, Wheel>
     */
    #[ORM\ManyToMany(targetEntity: Wheel::class, mappedBy: 'velos')]
    #[Assert\Count(min: 1, minMessage: 'Sélectionner au moins une taille de roue')]
    private Collection $wheels;

    /**
     * @var Collection<int, Transmission>
     */
    #[ORM\ManyToMany(targetEntity: Transmission::class, mappedBy: 'velos')]
    #[Assert\Count(min: 1, minMessage: 'Sélectionner au moins un nombre de vitesse')]
    private Collection $transmissions;

    #[ORM\ManyToOne(inversedBy: 'velos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Brand $brand = null;

    //  Constructor
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->notes = new ArrayCollection();
        $this->frames = new ArrayCollection();
        $this->wheels = new ArrayCollection();
        $this->transmissions = new ArrayCollection();
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

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
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection<int, Notes>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Notes $note): static
    {
    // Vérifie si la note n'est pas déjà présente dans la collection "notes"
    if (!$this->notes->contains($note)) {
        
        // Si la note n'est pas présente, on l'ajoute à la collection de "notes" de l'objet courant
        $this->notes->add($note);
        
        // Ensuite, on définit la relation bidirectionnelle en associant cette note
        // à l'objet courant (vélo), en appelant "setVelo" sur la note
        $note->setVelo($this);
    }

    // Retourne l'instance courante après avoir ajouté la note
    return $this;
    }

    public function removeNote(Notes $note): static
    {
        // Vérifie si la note est présente dans la collection "notes" de l'objet courant
        if ($this->notes->removeElement($note)) {
            
            // Si la note était bien présente et a été retirée, vérifier si la relation
            // entre la note et le vélo est encore établie
            if ($note->getVelo() === $this) {
                
                // Si la note est encore liée à ce vélo, on retire cette relation
                // en définissant la relation côté "note" (propriété "velo") à null
                $note->setVelo(null);
            }
        }
    
        // Retourne l'instance courante après avoir modifié la collection de notes
        return $this;
    }
    /**
     * @return Collection<int, Frame>
     */
    public function getFrames(): Collection
    {
        return $this->frames;
    }

    public function addFrame(Frame $frame): static
    {
        if (!$this->frames->contains($frame)) {
            $this->frames->add($frame);
            $frame->addVelo($this);
        }

        return $this;
    }

    public function removeFrame(Frame $frame): static
    {
        if ($this->frames->removeElement($frame)) {
            $frame->removeVelo($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Wheel>
     */
    public function getWheels(): Collection
    {
        return $this->wheels;
    }

    public function addWheel(Wheel $wheel): static
    {
        if (!$this->wheels->contains($wheel)) {
            $this->wheels->add($wheel);
            $wheel->addVelo($this);
        }

        return $this;
    }

    public function removeWheel(Wheel $wheel): static
    {
        if ($this->wheels->removeElement($wheel)) {
            $wheel->removeVelo($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Transmission>
     */
    public function getTransmissions(): Collection
    {
        return $this->transmissions;
    }

    public function addTransmission(Transmission $transmission): static
    {
        if (!$this->transmissions->contains($transmission)) {
            $this->transmissions->add($transmission);
            $transmission->addVelo($this);
        }

        return $this;
    }

    public function removeTransmission(Transmission $transmission): static
    {
        if ($this->transmissions->removeElement($transmission)) {
            $transmission->removeVelo($this);
        }

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }
}
