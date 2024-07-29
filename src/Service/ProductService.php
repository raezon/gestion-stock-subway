<?php

// src/Service/ProductService.php
namespace App\Service;

use App\Entity\Ingrediant;
use App\Entity\Product;
use App\Entity\ProductAssociation;
use App\Entity\Recipe;
use App\Entity\RecipeIngrediant;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createIngredient(string $name, string $quantity): Ingrediant
    {
        $ingredient = new Ingrediant();
        $ingredient->setName($name);
        $ingredient->setQuantity($quantity);
        $ingredient->setCreatedAt(new \DateTimeImmutable());
        $ingredient->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($ingredient);
        $this->entityManager->flush();

        return $ingredient;
    }

    public function createRecipe(string $name, $duration, array $ingredients): Recipe
    {
        $recipe = new Recipe();
        $recipe->setName($name);
        $recipe->setDuration($duration);
        $recipe->setCreatedAt(new \DateTimeImmutable());
        $recipe->setUpdatedAt(new \DateTimeImmutable());

        foreach ($ingredients as $ingredientData) {
            $ingredient = $this->createIngredient($ingredientData['name'], $ingredientData['quantity']);

            $recipeIngredient = new RecipeIngrediant();
            $recipeIngredient->setRecipe($recipe);
            $recipeIngredient->setIngredient($ingredient);
            $recipeIngredient->setQuantity($ingredientData['quantity']);
            $recipeIngredient->setCreatedAt(new \DateTimeImmutable());
            $recipeIngredient->setUpdatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($recipeIngredient);
        }

        $this->entityManager->persist($recipe);
        $this->entityManager->flush();

        return $recipe;
    }

    public function createProduct(string $name, float $price, string $image, string $type, int $associatedId): Product
    {
        $product = new Product();
        $product->setName($name);
        $product->setPrice($price);
        $product->setImage($image);
        //  $product->setType($type);
        $product->setCreatedAt(new \DateTimeImmutable());
        $product->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $productAssociation = new ProductAssociation();
        $productAssociation->setProduct($product);
        $productAssociation->setAssociatedId($associatedId);
        $productAssociation->setAssociatedType($type);
        $productAssociation->setCreatedAt(new \DateTimeImmutable());
        $productAssociation->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($productAssociation);
        $this->entityManager->flush();

        return $product;
    }

    public function getProductAssociations(Product $product): array
    {
        $repository = $this->entityManager->getRepository(ProductAssociation::class);
        return $repository->findBy(['product' => $product]);
    }

    public function buyProduct(Product $product): string
    {
        // Fetch the associated entities based on type
        $associations = $this->getProductAssociations($product);

        foreach ($associations as $association) {
            if ($association->getAssociatedType() === 'ingredient') {
                $ingredient = $this->entityManager->getRepository(Ingrediant::class)->find($association->getAssociatedId());
                $currentQuantity = $ingredient->getQuantity();

                if ($currentQuantity > 0) {
                    $ingredient->setQuantity($currentQuantity - 1);
                    $this->entityManager->flush();
                    return 'Ingredient bought successfully! New quantity: ' . ($currentQuantity - 1);
                } else {
                    return 'Ingredient is out of stock.';
                }
            } elseif ($association->getAssociatedType() === 'recipe') {
                $recipe = $this->entityManager->getRepository(Recipe::class)->find($association->getAssociatedId());
                $recipeIngredients = $this->entityManager->getRepository(RecipeIngrediant::class)->findBy(['Recipe' => $recipe]);

                $enoughStock = true;
                foreach ($recipeIngredients as $recipeIngredient) {
                    $ingredient = $recipeIngredient->getIngredient();
                    $quantityNeeded = $recipeIngredient->getQuantity();
                    $ingredientQuantity = $ingredient->getQuantity();

                    if ($ingredientQuantity < $quantityNeeded) {
                        $enoughStock = false;
                        break;
                    }
                }

                if ($enoughStock) {
                    foreach ($recipeIngredients as $recipeIngredient) {
                        $ingredient = $recipeIngredient->getIngredient();
                        $quantityNeeded = $recipeIngredient->getQuantity();
                        $ingredient->setQuantity($ingredient->getQuantity() - $quantityNeeded);
                    }

                    $this->entityManager->flush();
                    return 'Recipe bought successfully!';
                } else {
                    return 'Not enough stock for all ingredients of this recipe.';
                }
            }
        }

        return 'This product type is not supported for buying.';
    }

    public function getProductById(int $id): ?Product
    {
        return $this->entityManager->getRepository(Product::class)->find($id);
    }
}
