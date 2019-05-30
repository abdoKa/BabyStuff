<?php

namespace App\Entity;



use App\Entity\CommandeProduit;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 * 
 * @UniqueEntity({"referance"},
 * message="ce referance est déja utilisé!! ",
 * errorPath="referance"
 * )
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
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank
     * @Assert\Length(min=3,max=255,
     *  maxMessage="ce referance ne peut pas contenir plus de 255 caractères",
     *  minMessage="Ce referance doit être au moins 3 caractères"
     * 
     * )
     */
    private $referance;

   /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     * min=3,
     * max=255,
     * minMessage="Ce Nom doit être au moins 3 caractère.",
     * maxMessage="Ce Nom ne peut pas contenir plus de 255 caractères"
     * )
     */
    private $nom;

  /**
     * @ORM\Column(type="text", nullable=true)
     * 
     */
    private $description = 'default value to overwrite';

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\File(
     *     mimeTypes={"image/jpeg", "image/png"},
     *     mimeTypesMessage="Please upload a valid jpeg or png"
     * )
     * @Assert\NotBlank(
     * message="ce champ ne doit pas etre vide !"
     * )
     */
    private $image;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     * @Assert\NotBlank
     */
    private $prix;

    /**
     * @ORM\Column(type="boolean")
     */
    private $features=0;

    /**
     * @ORM\Column(type="integer")
     * 
     */
    private $stock;

    /**
     * @Gedmo\Slug(fields={"nom"})
     * @ORM\Column(type="string", length=50, unique=true)
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
     * @Gedmo\Timestampable(on="create")
     */
    private $dateAjout;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $dateModif;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommandeProduit", mappedBy="produit", cascade={"remove"})
     */
    private $commandeProduits;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductLike", mappedBy="product")
     */
    private $productLikes;

    public function __construct()
    {
        $this->commandeProduits = new ArrayCollection();
        $this->productLikes = new ArrayCollection();
    }


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

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        if($image !== null) {
            $this->image = $image;

            return $this;
        } 
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
     * Get the value of features
     */ 
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * Set the value of features
     *
     * @return  self
     */ 
    public function setFeatures($features)
    {
        $this->features = $features;

        return $this;
    }

    /**
     * @return Collection|CommandeProduit[]
     */
    public function getCommandeProduits(): Collection
    {
        return $this->commandeProduits;
    }

    public function addCommandeProduit(CommandeProduit $commandeProduit): self
    {
        if (!$this->commandeProduits->contains($commandeProduit)) {
            $this->commandeProduits[] = $commandeProduit;
            $commandeProduit->setProduit($this);
        }

        return $this;
    }

    public function removeCommandeProduit(CommandeProduit $commandeProduit): self
    {
        if ($this->commandeProduits->contains($commandeProduit)) {
            $this->commandeProduits->removeElement($commandeProduit);
            // set the owning side to null (unless already changed)
            if ($commandeProduit->getProduit() === $this) {
                $commandeProduit->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProductLike[]
     */
    public function getProductLikes(): Collection
    {
        return $this->productLikes;
    }

    public function addProductLike(ProductLike $productLike): self
    {
        if (!$this->productLikes->contains($productLike)) {
            $this->productLikes[] = $productLike;
            $productLike->setProduct($this);
        }

        return $this;
    }

    public function removeProductLike(ProductLike $productLike): self
    {
        if ($this->productLikes->contains($productLike)) {
            $this->productLikes->removeElement($productLike);
            // set the owning side to null (unless already changed)
            if ($productLike->getProduct() === $this) {
                $productLike->setProduct(null);
            }
        }

        return $this;
    }
      /**
       * knew if this product liked by user
       *
       * @param Utilisateur $User
       * @return boolean
       */
     public function isLikedByUser(Utilisateur $User):bool
    {
       foreach($this->productLikes as $like){
           if($like->getUtilisateur() === $User) return true;
       }
       return false;
    }

    
   
}