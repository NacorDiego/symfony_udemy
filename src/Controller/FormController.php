<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request; //Nos va a ayudar a recibir los campos de nuestro form.
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
    public function bootstrap( Request $request ): Response
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

        $form->handleRequest($request); //Permite recibir los campos del form.
        //Si viene la petición POST del form
        if($form->isSubmitted()){
            $campos = $form->getData(); //Guarda la data del form en $campos.
            print_r($campos);
            echo "Nombre:".$campos['nombre']; //Se utiliza esta forma cuando a createFormBuilder se le pasa null. Con entidades es distinto.
            die;
        }
        return $this->render('form/bootstrap.html.twig', compact('form'));
    }
}
