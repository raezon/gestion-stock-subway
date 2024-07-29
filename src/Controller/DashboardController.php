<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\StorePanelService;

class DashboardController extends AbstractController
{
    private $storePanelService;

    public function __construct(StorePanelService $storePanelService)
    {
        $this->storePanelService = $storePanelService;
    }


    #[Route('/', name: 'dashboard')]
    public function index(): Response
    {
        $panels = $this->storePanelService->getPanels();

        $user = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ];

        return $this->render('dashboard/index.html.twig', [
            'panels' => $panels,
            'user' => $user,
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(): Response
    {
        return 'logout';
    }


}
