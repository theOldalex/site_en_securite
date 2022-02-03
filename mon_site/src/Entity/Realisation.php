<?php

namespace App\Entity;

use App\Repository\RealisationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=RealisationRepository::class)
 *  @Vich\Uploadable
 */
class Realisation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $auteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_image;

    /**
     * @ORM\Column(type="date")
     */
    private $date_publication;

    /**
     * @ORM\Column(type="text")
     */
    private $description_image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

     /**
     * @Vich\UploadableField(mapping="realisation_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @var string
     * 
     * @Gedmo\Slug(fields={"nom_image"})
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Auteur::class, mappedBy="realisation", orphanRemoval=true)
     */
    private $Auteur;

    public function __construct()
    {
        $this->Auteur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getNomImage(): ?string
    {
        return $this->nom_image;
    }

    public function setNomImage(string $nom_image): self
    {
        $this->nom_image = $nom_image;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->date_publication;
    }

    public function setDatePublication(\DateTimeInterface $date_publication): self
    {
        $this->date_publication = $date_publication;

        return $this;
    }

    public function getDescriptionImage(): ?string
    {
        return $this->description_image;
    }

    public function setDescriptionImage(string $description_image): self
    {
        $this->description_image = $description_image;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null)
    {
        $this->imageFile = $imageFile;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function addAuteur(Auteur $auteur): self
    {
        if (!$this->Auteur->contains($auteur)) {
            $this->Auteur[] = $auteur;
            $auteur->setRealisation($this);
        }

        return $this;
    }

    public function removeAuteur(Auteur $auteur): self
    {
        if ($this->Auteur->removeElement($auteur)) {
            // set the owning side to null (unless already changed)
            if ($auteur->getRealisation() === $this) {
                $auteur->setRealisation(null);
            }
        }

        return $this;
    }

}
