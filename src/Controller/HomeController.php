<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_inicio')]
    public function Home(): Response
    {
        $array = ['cs','lol','minecraft','among us','pato'];
        return $this->render('home/index.html.twig',['array' => $array]);
    }

    #[Route('/home/saludo', name: 'home_saludo')]
    public function saludo(): Response
    {
        die("hola te saludo");
    }

    #[Route('/home/despedida', name: 'home_despedida')]
    public function despedida(): Response
    {
        throw $this->createNotFoundException('Esta URL no está disponible');
    }
}
