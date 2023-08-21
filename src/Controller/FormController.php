<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FormController extends AbstractController
{
    #[Route('/form', name: 'form_home')]
    public function index(): Response
    {
        return $this->render('form/index.html.twig');
    }
    #[Route('/form/simple', name: 'form_simple')]
    public function simple(): Response
    {
        // Creo un formulario mediante creaFormBuilder.
        $formulario = $this->createFormBuilder(null)
                    ->add('nombre',TextType::class, ['label'=>'Nombre'])
                    ->add('imagen',TextType::class,['label'=>'Imagen'])
                    ->add('descripcion',TextareaType::class,['label'=>'Descripción'])
                    ->add('plataforma')
                    ->add('genero')
                    ->add('url',UrlType::class,['label'=>'Sitio web'])
                    ->add('addGame',SubmitType::class)
                    ->getForm();
        return $this->render('form/simple.html.twig', compact('formulario'));
    }
    #[Route('/form/bootstrap', name: 'form_bootstrap')]
    public function bootstrap(): Response
    {
        // Creo un formulario mediante creaFormBuilder.
        $form = $this->createFormBuilder(null)
                    ->add('nombre',TextType::class, ['label'=>'Nombre'])
                    ->add('imagen',TextType::class,['label'=>'Imagen'])
                    ->add('descripcion',TextareaType::class,['label'=>'Descripción'])
                    ->add('plataforma')
                    ->add('genero')
                    ->add('url',UrlType::class,['label'=>'Sitio web'])
                    ->add('addGame',SubmitType::class)
                    ->getForm();
        return $this->render('form/bootstrap.html.twig', compact('form'));
    }
}
