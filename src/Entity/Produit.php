<?php

namespace App\Entity;


use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 * @UniqueEntity("slug")
 * @Vich\Uploadable
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Ce champ doit être au moins 2 caractères.",
     *      maxMessage = "Ce champ ne peut pas contenir plus de 255 caractères"
     * )
     */
    private $referance;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Ce Nom doit être au moins 2 caractères.",
     *      maxMessage = "Ce Nom ne peut pas contenir plus de 255 caractères"
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename;


    /**
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="filename")
     * @var File
     */
    private $imageFile;


    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     * @Assert\NotBlank
     */
    private $prix;

    /**
     * @ORM\Column(type="boolean")
     */
    private $features;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $stock;

    /**
     * @ORM\Column(type="string", length=170)
     * 
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fourniseur", inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fourniseur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAjout;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateModif;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReferance(): ?string
    {
        return $this->referance;
    }

    public function setReferance(string $referance): self
    {
        $this->referance = $referance;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function setPrix($prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getFeatures(): ?bool
    {
        return $this->features;
    }

    public function setFeatures(bool $features): self
    {
        $this->features = $features;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getFourniseur(): ?Fourniseur
    {
        return $this->fourniseur;
    }

    public function setFourniseur(?Fourniseur $fourniseur): self
    {
        $this->fourniseur = $fourniseur;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->dateAjout;
    }

    public function setDateAjout(\DateTimeInterface $dateAjout): self
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    public function getDateModif(): ?\DateTimeInterface
    {
        return $this->dateModif;
    }

    public function setDateModif(\DateTimeInterface $dateModif): self
    {
        $this->dateModif = $dateModif;

        return $this;
    }

   
    /**
     * Get the value of imageFile
     *
     * @return  File
     */ 
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set the value of imageFile
     *
     * @param  File  $imageFile
     *
     * @return  self
     */ 
    public function setImageFile(File $imageFile)
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    /**
     * Get the value of filename
     *
     * @return  string|null
     */ 
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set the value of filename
     *
     * @param  string|null  $filename
     *
     * @return  self
     */ 
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }
}
