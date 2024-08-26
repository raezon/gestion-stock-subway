<?php
namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    #[Route('/recipe/new', name: 'recipe_new')]
    public function new(Request $request): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ingredients = $form->get('ingredients')->getData();

            $this->productService->createRecipe(
                $recipe->getName(),
                $recipe->getDuration(),
                $ingredients
            );

            return $this->redirectToRoute('recipe_success');
        }

        return $this->render('create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/recipe/success', name: 'recipe_success')]
    public function success(): Response
    {
        return $this->render('update.html.twig');
    }
}
