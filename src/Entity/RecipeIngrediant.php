<?php

namespace App\Entity;

use App\Repository\RecipeIngrediantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeIngrediantRepository::class)]
class RecipeIngrediant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(targetEntity: 'Recipe', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recipe $Recipe = null;

    #[ORM\ManyToOne(targetEntity: 'Ingrediant', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ingrediant $ingredient = null;



    public function getRecipe(): ?Recipe
    {
        return $this->Recipe;
    }

    public function setRecipe(?Recipe $recipe): static
    {
        $this->Recipe = $recipe;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
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



    public function getIngredient(): ?Ingrediant
    {
        return $this->ingredient;
    }

    public function setIngredient(?Ingrediant $ingredient): static
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getIngrediant(): ?Ingrediant
    {
        return $this->ingrediant;
    }

    public function setIngrediant(?Ingrediant $ingrediant): static
    {
        $this->ingrediant = $ingrediant;

        return $this;
    }
}
