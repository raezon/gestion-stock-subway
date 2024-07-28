<?php

// src/Controller/ProductController.php
namespace App\Controller;

use App\Entity\Ingrediant;
use App\Entity\Product;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Entity\RecipeIngrediant;
use App\Entity\RecipeIngredient;
use App\Repository\IngrediantRepository;
use App\Repository\ProductRepository;
use App\Repository\IngredientRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager;
    private $productRepository;
    private $ingredientRepository;
    private $recipeRepository;

    public function __construct(EntityManagerInterface $entityManager, ProductRepository $productRepository, IngrediantRepository $ingredientRepository, RecipeRepository $recipeRepository)
    {
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
        $this->ingredientRepository = $ingredientRepository;
        $this->recipeRepository = $recipeRepository;
    }

    #[Route('/product/test', name: 'product_test')]
    public function test(): Response
    {
        // Create a new ingredient
        $ingredient = new Ingrediant();
        $ingredient->setName('Sugar');
        $ingredient->setQuantity(100);
        $ingredient->setPicture('sugar.jpg');
        $ingredient->setPrice(1.99);
        $ingredient->setImage('sugar.jpg');
        //  $ingredient->setCreatedAt(new \DateTimeImmutable());
        //  $ingredient->setUpdatedAt(new \DateTimeImmutable());

        // Create a new recipe
        $recipe = new Recipe();
        $recipe->setPrice(9.99);
        $recipe->setImage('recipe.jpg');
        $recipe->setCreatedAt(new \DateTimeImmutable());
        $recipe->setUpdatedAt(new \DateTimeImmutable());

        // Add the ingredient to the recipe with quantity
        $recipeIngredient = new RecipeIngrediant();
        $recipeIngredient->setIngredient($ingredient);
        $recipeIngredient->setRecipe($recipe);
        $recipeIngredient->setQuantity(50);
        $recipeIngredient->setCreatedAt(new \DateTimeImmutable());
        $recipeIngredient->setUpdatedAt(new \DateTimeImmutable());



        // Persist and flush
        $this->entityManager->persist($ingredient);
        $this->entityManager->persist($recipe);
        $this->entityManager->persist($recipeIngredient);
        $this->entityManager->flush();

        return new Response('Test entities created successfully!');
    }

    #[Route('/product/show/{id}', name: 'product_show')]
    public function show(int $id): Response
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }

        // Determine the type of product
        if ($product instanceof Ingredient) {
            return new Response('This is an ingredient: ' . $product->getName());
        } elseif ($product instanceof Recipe) {
            return new Response('This is a recipe: ' . $product->getName());
        } else {
            return new Response('This is a generic product.');
        }
    }

    #[Route('/product/buy/{id}', name: 'product_buy')]
    public function buy(int $id): Response
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }

        // If the product is an ingredient, decrement its quantity
        if ($product instanceof Ingredient) {
            $quantity = $product->getQuantity();
            if ($quantity > 0) {
                $product->setQuantity($quantity - 1);
            } else {
                return new Response('Ingredient is out of stock.');
            }
        }

        // If the product is a recipe, decrement the quantities of its ingredients
        if ($product instanceof Recipe) {
            foreach ($product->getRecipeIngredients() as $recipeIngredient) {
                $ingredient = $recipeIngredient->getIngredient();
                $quantityNeeded = $recipeIngredient->getQuantity();
                $ingredientQuantity = $ingredient->getQuantity();

                if ($ingredientQuantity >= $quantityNeeded) {
                    $ingredient->setQuantity($ingredientQuantity - $quantityNeeded);
                } else {
                    return new Response('Not enough stock for ingredient: ' . $ingredient->getName());
                }
            }
        }

        $this->entityManager->flush();

        return new Response('Product bought successfully!');
    }
}