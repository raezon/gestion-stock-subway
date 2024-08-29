<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\RecipeIngrediant;
use App\Entity\Ingrediant;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class RecipeController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/recipe/new', name: 'recipe_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        if ($request->isMethod('POST')) {
            // Extract POST data
            $data = $request->request->all();
            $data = $data['recipe'];

            // Validate the received data (basic checks)
            if (!isset($data['name']) || !isset($data['duration']) || !isset($data['ingredients'])) {
                return new JsonResponse(['error' => 'Invalid input'], Response::HTTP_BAD_REQUEST);
            }

            $recipe = new Recipe();
            $recipe->setName($data['name']);
            $recipe->setDuration($data['duration']);

            // Persist the Recipe entity first
            $this->entityManager->persist($recipe);
            $this->entityManager->flush(); // Ensure Recipe ID is generated

            // Process ingredients data
            $ingredientsData = $data['ingredients'];
            if (json_last_error() === JSON_ERROR_NONE) {
                foreach ($ingredientsData as $ingredientData) {
                    $ingredient = $this->entityManager->getRepository(Ingrediant::class)->find($ingredientData['ingredient']);

                    if ($ingredient) {
                        $recipeIngredient = new RecipeIngrediant();
                        $recipeIngredient->setRecipe($recipe);
                        $recipeIngredient->setIngredient($ingredient);
                        $recipeIngredient->setQuantity($ingredientData['quantity']);

                        // Persist each RecipeIngrediant entity
                        $this->entityManager->persist($recipeIngredient);
                    } else {
                        return new JsonResponse(['error' => 'Ingredient not found'], Response::HTTP_BAD_REQUEST);
                    }
                }
            } else {
                return new JsonResponse(['error' => 'Invalid ingredients format'], Response::HTTP_BAD_REQUEST);
            }

            // Flush all changes to persist RecipeIngrediant entities
            $this->entityManager->flush();

            return $this->redirectToRoute('recipes_list');
        }

        // Render the form view for creating a new recipe
        return $this->render('recipe/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/recipes', name: 'recipes_list')]
    public function list(RecipeRepository $recipeRepository): Response
    {
        // Fetch all recipes with their associated ingredients
        $recipes = $recipeRepository->findAll();

        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    #[Route('/recipe/{id}', name: 'recipe_show', methods: ['GET'])]
    public function show(Recipe $recipe): Response
    {
        // Ensure Recipe exists
        if (!$recipe) {
            throw $this->createNotFoundException('Recipe not found');
        }

        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    #[Route('/recipe/{id}/edit', name: 'recipe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recipe $recipe): Response
    {
        // Ensure Recipe exists
        if (!$recipe) {
            throw $this->createNotFoundException('Recipe not found');
        }

        if ($request->isMethod('POST')) {
            // Extract POST data
            $data = $request->request->all();
            $data = $data['recipe'];

            // Validate the received data (basic checks)
            if (!isset($data['name']) || !isset($data['duration']) || !isset($data['ingredients'])) {
                return new JsonResponse(['error' => 'Invalid input'], Response::HTTP_BAD_REQUEST);
            }

            $recipe->setName($data['name']);
            $recipe->setDuration($data['duration']);

            // Remove existing RecipeIngrediant entities
            foreach ($recipe->getIngredients() as $existingRecipeIngredient) {
                $this->entityManager->remove($existingRecipeIngredient);
            }

            // Process ingredients data
            $ingredientsData = json_decode($data['ingredients'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                foreach ($ingredientsData as $ingredientData) {
                    $ingredient = $this->entityManager->getRepository(Ingrediant::class)->find($ingredientData['ingredient']);

                    if ($ingredient) {
                        $recipeIngredient = new RecipeIngrediant();
                        $recipeIngredient->setRecipe($recipe);
                        $recipeIngredient->setIngredient($ingredient);
                        $recipeIngredient->setQuantity($ingredientData['quantity']);

                        // Persist each RecipeIngrediant entity
                        $this->entityManager->persist($recipeIngredient);
                    } else {
                        return new JsonResponse(['error' => 'Ingredient not found'], Response::HTTP_BAD_REQUEST);
                    }
                }
            } else {
                return new JsonResponse(['error' => 'Invalid ingredients format'], Response::HTTP_BAD_REQUEST);
            }

            // Flush all changes to update RecipeIngrediant entities
            $this->entityManager->flush();

            return $this->redirectToRoute('recipes_list');
        }

        return $this->render('recipe/edit.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    #[Route('/recipe/{id}/delete', name: 'recipe_delete', methods: ['POST'])]
    public function delete(Request $request, Recipe $recipe): Response
    {
        // Ensure Recipe exists
        if (!$recipe) {
            throw $this->createNotFoundException('Recipe not found');
        }

        if ($this->isCsrfTokenValid('delete' . $recipe->getId(), $request->request->get('_token'))) {
            // Remove the Recipe and associated RecipeIngrediant entities
            foreach ($recipe->getIngredients() as $recipeIngredient) {
                $this->entityManager->remove($recipeIngredient);
            }
            $this->entityManager->remove($recipe);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('recipes_list');
    }
}
