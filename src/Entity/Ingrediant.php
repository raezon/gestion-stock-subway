<?php

namespace App\Entity;

use App\Repository\IngrediantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngrediantRepository::class)]
/**
 * @ORM\Entity()
 * @ORM\Table(name="ingrediant")
 */
class Ingrediant
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;


    /**
     * @var Collection<int, RecipeIngrediant>
     */
    #[ORM\OneToMany(targetEntity: RecipeIngrediant::class, mappedBy: 'ingredient')]
    private Collection $RecipeIngrediants;

    /**
     * @var Collection<int, RecipeIngrediant>
     */
    #[ORM\OneToMany(targetEntity: RecipeIngrediant::class, mappedBy: 'ingrediant', orphanRemoval: true)]
    private Collection $recipeIngrediants;

    public function __construct()
    {
        $this->RecipeIngrediants = new ArrayCollection();
        $this->recipeIngrediants = new ArrayCollection();
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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getcreated_at(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getupdated_at(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setupdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, RecipeIngrediant>
     */
    public function getRecipeIngrediants(): Collection
    {
        return $this->RecipeIngrediants;
    }

    public function addRecipeIngrediant(RecipeIngrediant $RecipeIngrediant): static
    {
        if (!$this->RecipeIngrediants->contains($RecipeIngrediant)) {
            $this->RecipeIngrediants->add($RecipeIngrediant);
            $RecipeIngrediant->setIngredient($this);
        }

        return $this;
    }

    public function removeRecipeIngrediant(RecipeIngrediant $RecipeIngrediant): static
    {
        if ($this->RecipeIngrediants->removeElement($RecipeIngrediant)) {
            // set the owning side to null (unless already changed)
            if ($RecipeIngrediant->getIngredient() === $this) {
                $RecipeIngrediant->setIngredient(null);
            }
        }

        return $this;
    }
}
