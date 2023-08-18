<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GendersController extends AbstractController
{
    #[Route('/generos', name: 'genders_home')]
    public function index(): Response
    {
        return $this->render('genders/index.html.twig');
    }
}
