<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/recipe/new', name: 'recipe_new')]
    public function new(Request $request): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        //$form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the Recipe entity
            $this->entityManager->persist($recipe);

            // Persist RecipeIngrediant entities if needed
            foreach ($recipe->getIngredients() as $recipeIngredient) {
                $recipeIngredient->setRecipe($recipe);
                $this->entityManager->persist($recipeIngredient);
            }

            $this->entityManager->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('recette/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
