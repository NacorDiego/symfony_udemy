<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TemplateController extends AbstractController {
    #[Route('/template', name: 'template_inicio')]
    public function index(): Response
    {
        return $this->render('template/index.html.twig');
    }

    // Ruta con parametros
    #[Route('/template/parametros/{id}/{slug}', name: 'template_parametros', defaults:['id' => 0, 'slug' => 'default'])]
    public function parametros( int $id, string $slug): Response
    {
        // Valida el valor de ID y sino devuelve una excepción mediante error 404 personalizado
        if ($id > 3){
            die('id = '.$id. ' | slug = '.$slug);
        } else {
            throw $this->createNotFoundException('El valor del ID no es el esperado.');
        }
    }

    // Estado 404 personalizado
    #[Route('/template/exception', name: 'template_excepcion')]
    public function excepcion(): Response
    {
        throw $this->createNotFoundException('Esta URL no está disponible');
    }
}