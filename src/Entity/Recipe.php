<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Product;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $duration = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;




    /**
     * @var Collection<int, RecipeIngrediant>
     */
    #[ORM\OneToMany(targetEntity: RecipeIngrediant::class, mappedBy: 'recipe', orphanRemoval: true)]
    private Collection $recipeIngrediants;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }



    public function getingredients(): Collection
    {
        return $this->ingredients;
    }

    public function addRecipeIngredient(RecipeIngrediant $recipeIngredient): static
    {
        if (!$this->ingredients->contains($recipeIngredient)) {
            $this->ingredients->add($recipeIngredient);
            $recipeIngredient->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeIngredient(RecipeIngrediant $recipeIngredient): static
    {
        if ($this->ingredients->removeElement($recipeIngredient)) {
            // set the owning side to null (unless already changed)
            if ($recipeIngredient->getRecipe() === $this) {
                $recipeIngredient->setRecipe(null);
            }
        }

        return $this;
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

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): static
    {
        $this->duration = $duration;

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
        return $this->recipeIngrediants;
    }

    public function addRecipeIngrediant(RecipeIngrediant $recipeIngrediant): static
    {
        if (!$this->recipeIngrediants->contains($recipeIngrediant)) {
            $this->recipeIngrediants->add($recipeIngrediant);
            $recipeIngrediant->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeIngrediant(RecipeIngrediant $recipeIngrediant): static
    {
        if ($this->recipeIngrediants->removeElement($recipeIngrediant)) {
            // set the owning side to null (unless already changed)
            if ($recipeIngrediant->getRecipe() === $this) {
                $recipeIngrediant->setRecipe(null);
            }
        }

        return $this;
    }
}
