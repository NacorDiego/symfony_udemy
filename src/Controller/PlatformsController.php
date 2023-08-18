<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlatformsController extends AbstractController
{
    #[Route('/plataformas', name: 'platforms_home')]
    public function index(): Response
    {
        return $this->render('platforms/index.html.twig', [
            'controller_name' => 'PlatformsController',
        ]);
    }
}
