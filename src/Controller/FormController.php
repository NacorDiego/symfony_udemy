<?php

namespace App\Controller;

use App\Entity\Game; //Importo la entidad Game.
use App\Entity\GameForm; //Importo la entidad Game.
use App\Form\GameFormType;
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
    //FORMULARIO CLASICO SIN SYMFONY
    #[Route('/form', name: 'form_home')]
    public function index(): Response
    {
        return $this->render('form/index.html.twig');
    }

    //FORMULARIO SIMPLE
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

    //FORMULARIO BOOTSTRAP
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
        $submittedToken=$request->request->get('token'); //Permite recibir el token del formulario y guardarlo en la variable.
        $form->handleRequest($request); //Permite recibir los campos del form.
        //Si viene la petición POST del form
        //if($form->isSubmitted())
        if($form->isSubmitted()) //Controla que el token sea válido
        {
            if ($this->isCsrfTokenValid('generico',$submittedToken)) {
                $campos = $form->getData(); //Guarda la data del form en $campos.
                print_r($campos);
                echo "Nombre:".$campos['nombre']; //Se utiliza esta forma para obtener los datos de un input en particular, cuando a createFormBuilder se le pasa null. Con entidades es distinto.
                die;
            } else {
                $this->addFlash('css','danger'); //Agrego un msj flash con el css de un alert de bootstrap de color warning.
                $this->addFlash('mensaje','La validación de token falló.'); //Agrego un msj flash con el texto del msj que quiero mostrar.
                return $this->redirectToRoute('form_bootstrap'); //Redirecciono a la misma vista para que se recargue la página.
            }
        }
        return $this->render('form/bootstrap.html.twig', compact('form')); //Mediante el helper 'compact()' paso el $form al template
    }

    //FORMULARIO ENTITY
    #[Route('/form/entity', name: 'form_entity')]
    public function entity( Request $request ): Response
    {
        // Declaro una instancia de la entidad 'Persona'.
        $game = new Game();
        // Creo un formulario mediante creaFormBuilder relacionado a la entidad Persona (Ahora solo puedo crear campos relacionados a los atributos de la entidad).
        $form = $this->createFormBuilder($game)
                    ->add('name',TextType::class, ['label'=>'Name'])
                    ->add('image',TextType::class,['label'=>'Image'])
                    ->add('description',TextareaType::class,['label'=>'Description'])
                    ->add('platform')
                    ->add('gender')
                    ->add('url',UrlType::class,['label'=>'Sitio web'])
                    ->add('addGame',SubmitType::class)
                    ->getForm();
        $submittedToken=$request->request->get('token'); //Permite recibir el token del formulario y guardarlo en la variable.
        $form->handleRequest($request); //Permite recibir los campos del form.
        if($form->isSubmitted()) //Si viene la petición POST del form
        {
            if ($this->isCsrfTokenValid('generico',$submittedToken)) { //Controla que el token sea válido
                $campos = $form->getData(); //Guarda la data del form en $campos.
                print_r($campos);
                echo "Nombre:".$game->getName(); //Se utiliza esta forma para obtener los datos de un input en particular, cuando a createFormBuilder se le pasa null. Con entidades es distinto.
                die;
            } else {
                $this->addFlash('css','danger'); //Agrego un msj flash con el css de un alert de bootstrap de color warning.
                $this->addFlash('mensaje','La validación de token falló.'); //Agrego un msj flash con el texto del msj que quiero mostrar.
                return $this->redirectToRoute('form_entity'); //Redirecciono a la misma vista para que se recargue la página.
            }
        }
        return $this->render('form/entity.html.twig', compact('form')); //Mediante el helper 'compact()' paso el $form al template
    }

    //FORMULARIO TYPE
    #[Route('/form/type', name: 'form_type')]
    public function type( Request $request ): Response
    {
        $gameForm = new GameForm();
        $form = $this->createForm(GameFormType::class, $gameForm); // Creo el formulario con 'createForm()' y paso como argumento la clase 'GameFormType' y la instancia a la cual la voy a asociar '$game'
        return $this->render('form/type.html.twig', compact('form')); //Mediante el helper 'compact()' paso el $form al template
    }
}
