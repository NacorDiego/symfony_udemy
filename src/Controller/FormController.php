<?php

namespace App\Controller;

use App\Entity\Game; //Importo la ENTIDAD 'Game'.
use App\Entity\GameForm; //Importo la ENTIDAD 'GameForm'.
use App\Entity\GameFormValidation; // Importo la ENTIDAD 'GameFormValidation'
use App\Entity\GameFormUpload; // Importo la ENTIDAD 'GameFormValidation'
use App\Form\GameFormType; // Importo el FORMULARIO 'GameFormType'
use App\Form\GameFormValidationType; // Importo el FORMULARIO 'GameFormValidationType'
use App\Form\GameFormUploadType; // Importo el FORMULARIO 'GameFormValidationType'
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request; //Nos va a ayudar a recibir los campos de nuestro form.
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
            ->add('nombre', TextType::class, ['label' => 'Nombre'])
            ->add('imagen', TextType::class, ['label' => 'Imagen'])
            ->add('descripcion', TextareaType::class, ['label' => 'Descripción'])
            ->add('plataforma')
            ->add('genero')
            ->add('url', UrlType::class, ['label' => 'Sitio web'])
            ->add('addGame', SubmitType::class)
            ->getForm();
        return $this->render('form/simple.html.twig', compact('formulario'));
    }

    //FORMULARIO BOOTSTRAP
    #[Route('/form/bootstrap', name: 'form_bootstrap')]
    public function bootstrap(Request $request): Response
    {
        // Creo un formulario mediante creaFormBuilder.
        $form = $this->createFormBuilder(null)
            ->add('nombre', TextType::class, ['label' => 'Nombre'])
            ->add('imagen', TextType::class, ['label' => 'Imagen'])
            ->add('descripcion', TextareaType::class, ['label' => 'Descripción'])
            ->add('plataforma')
            ->add('genero')
            ->add('url', UrlType::class, ['label' => 'Sitio web'])
            ->add('addGame', SubmitType::class)
            ->getForm();
        $submittedToken = $request->request->get('token'); //Permite recibir el token del formulario y guardarlo en la variable.
        $form->handleRequest($request); //Permite recibir los campos del form.
        //Si viene la petición POST del form
        //if($form->isSubmitted())
        if ($form->isSubmitted()) //Controla que el token sea válido
        {
            if ($this->isCsrfTokenValid('generico', $submittedToken)) {
                $campos = $form->getData(); //Guarda la data del form en $campos.
                print_r($campos);
                echo "Nombre:" . $campos['nombre']; //Se utiliza esta forma para obtener los datos de un input en particular, cuando a createFormBuilder se le pasa null. Con entidades es distinto.
                die;
            } else {
                $this->addFlash('css', 'danger'); //Agrego un msj flash con el css de un alert de bootstrap de color warning.
                $this->addFlash('mensaje', 'La validación de token falló.'); //Agrego un msj flash con el texto del msj que quiero mostrar.
                return $this->redirectToRoute('form_bootstrap'); //Redirecciono a la misma vista para que se recargue la página.
            }
        }
        return $this->render('form/bootstrap.html.twig', compact('form')); //Mediante el helper 'compact()' paso el $form al template
    }

    //FORMULARIO ENTITY
    // Esta manera de crear formularios es muy útil y se usa mucho cuando NO HAY BASES DE DATOS de por medio.
    #[Route('/form/entity', name: 'form_entity')]
    public function entity(Request $request): Response
    {
        // Declaro una instancia de la entidad 'Persona'.
        $game = new Game();
        // Creo un formulario mediante creaFormBuilder relacionado a la entidad Persona (Ahora solo puedo crear campos relacionados a los atributos de la entidad).
        $form = $this->createFormBuilder($game)
            ->add('name', TextType::class, ['label' => 'Name'])
            ->add('image', TextType::class, ['label' => 'Image'])
            ->add('description', TextareaType::class, ['label' => 'Description'])
            ->add('platform')
            ->add('gender')
            ->add('url', UrlType::class, ['label' => 'Sitio web'])
            ->add('addGame', SubmitType::class)
            ->getForm();
        $submittedToken = $request->request->get('token'); //Permite recibir el token del formulario y guardarlo en la variable.
        $form->handleRequest($request); //Permite recibir los campos del form.
        if ($form->isSubmitted()) //Si viene la petición POST del form
        {
            if ($this->isCsrfTokenValid('generico', $submittedToken)) { //Controla que el token sea válido
                $campos = $form->getData(); //Guarda la data del form en $campos.
                print_r($campos);
                echo "Nombre:" . $game->getName(); //Se utiliza esta forma para obtener los datos de un input en particular, cuando a createFormBuilder se le pasa null. Con entidades es distinto.
                die;
            } else {
                $this->addFlash('css', 'danger'); //Agrego un msj flash con el css de un alert de bootstrap de color warning.
                $this->addFlash('mensaje', 'La validación de token falló.'); //Agrego un msj flash con el texto del msj que quiero mostrar.
                return $this->redirectToRoute('form_entity'); //Redirecciono a la misma vista para que se recargue la página.
            }
        }
        return $this->render('form/entity.html.twig', compact('form')); //Mediante el helper 'compact()' paso el $form al template
    }

    //FORMULARIO TYPE
    // Esta es la forma más tradicional de trabajar con formularios en Symfony CUANDO HAY BASES DE DATOS de por medio.
    #[Route('/form/type', name: 'form_type')]
    public function type(Request $request): Response
    {
        $gameForm = new GameForm(); // Creo una instancia de la clase GameForm.
        $form = $this->createForm(GameFormType::class, $gameForm); // Creo el formulario con 'createForm()' y paso como argumento la clase 'GameFormType' y la instancia a la cual la voy a asociar '$game'
        $form->handleRequest($request); //Permite recibir los campos del form.
        $submittedToken = $request->request->get('token'); //Permite recibir el token del formulario y guardarlo en la variable.
        if ($form->isSubmitted()) //Si viene la petición POST del form
        {
            if ($this->isCsrfTokenValid('generico', $submittedToken)) { //Controla que el token sea válido
                $campos = $form->getData(); //Guarda la data del form en $campos.
                print_r($campos);
                echo "Nombre:" . $gameForm->getName(); //Se utiliza esta forma para obtener los datos de un input en particular, cuando a createFormBuilder se le pasa null. Con entidades es distinto.
                die;
            } else {
                $this->addFlash('css', 'danger'); //Agrego un msj flash con el css de un alert de bootstrap de color warning.
                $this->addFlash('mensaje', 'La validación de token falló.'); //Agrego un msj flash con el texto del msj que quiero mostrar.
                return $this->redirectToRoute('form_type'); //Redirecciono a la misma vista para que se recargue la página.
            }
        }
        return $this->render('form/type.html.twig', compact('form')); //Mediante el helper 'compact()' paso el $form al template
    }

    //FORMULARIO CLASICO SIN SYMFONY
    #[Route('/form/validacion', name: 'form_validacion')]
    public function validacion(Request $request, ValidatorInterface $validator): Response
    {
        $gameFormValidation = new GameFormValidation();
        $form = $this->createForm(GameFormValidationType::class, $gameFormValidation);
        $form->handleRequest($request); //Permite recibir los campos del form.
        $submittedToken = $request->request->get('token'); //Permite recibir el token del formulario y guardarlo en la variable.
        if ($form->isSubmitted()) // Si el formulario fue submiteado
        {
            if ($this->isCsrfTokenValid('generico', $submittedToken)) {
                $errors = $validator->validate($gameFormValidation); //Valida la instancia de la entidad 'gameFormValidation'. Los errores que ocurran en la validacion quedan guardados en '$errors'
                if (count($errors) > 0) // Si la variable $errors es mayor que 0 entonces quiere decir que se generó algun error en la validación.
                {
                    return $this->render('form/validacion.html.twig', ['form' => $form, 'errors' => $errors]); // Le paso a la vista el formulario de la forma tradicional, no con compact(). Paso la variable 'errors' con los errores para trabajarlo en la vista.
                } else {
                    $campos = $form->getData(); //Guarda la data del form en $campos.
                    print_r($campos);
                    echo "Nombre:" . $gameFormValidation->getName(); //Se utiliza esta forma para obtener los datos de un input en particular, cuando a createFormBuilder se le pasa null. Con entidades es distinto.
                    die;
                }
            } else {
                $this->addFlash('css', 'danger'); //Agrego un msj flash con el css de un alert de bootstrap de color warning.
                $this->addFlash('mensaje', 'La validación de token falló.'); //Agrego un msj flash con el texto del msj que quiero mostrar.
                return $this->redirectToRoute('form_validacion'); //Redirecciono a la misma vista para que se recargue la página.
            }
        }
        return $this->render('form/validacion.html.twig', ['form' => $form, 'errors' => array()]); // Le paso a la vista el formulario de la forma tradicional, no con compact(). Paso 'errors' como un array vacío para que no me de problemas en las validaciones.
    }

    //FORMULARIO UPLOAD
    #[Route('/form/upload', name: 'form_upload')]
    public function upload(Request $request, ValidatorInterface $validator): Response
    {
        $gameFormUpload = new GameFormUpload();
        $form = $this->createForm(GameFormUploadType::class, $gameFormUpload);
        $form->handleRequest($request); //Permite recibir los campos del form.
        $submittedToken = $request->request->get('token'); //Permite recibir el token del formulario y guardarlo en la variable.
        if ($form->isSubmitted()) // Si el formulario fue submiteado
        {
            if ($this->isCsrfTokenValid('generico', $submittedToken)) {
                $errors = $validator->validate($gameFormUpload); //Valida la instancia de la entidad 'gameFormUpload'. Los errores que ocurran en la validacion quedan guardados en '$errors'
                if (count($errors) > 0) // Si la variable $errors es mayor que 0 entonces quiere decir que se generó algun error en la validación.
                {
                    return $this->render('form/upload.html.twig', ['form' => $form, 'errors' => $errors]); // Le paso a la vista el formulario de la forma tradicional, no con compact(). Paso la variable 'errors' con los errores para trabajarlo en la vista.
                } else {
                    $image = $form -> get('image')->getData(); // Guardo el valor de la Imagen 'image' en $image.
                    if ($image)
                    {
                        $newFileName = time().'.'.$image->guessExtension(); // Le coloco un nombre especifico para almacenar la imagen y que no se repita.
                        try
                        {
                            // Upload de la imagen
                            $image->move(
                                $this->getParameter('images_directory'), // Se le pasa el nombre del directorio que se creo en services.yaml/parameters
                                $newFileName // Paso el nombre único que le doy a la imagen.
                            );
                        } catch (FileException $e)
                        {
                            // Si hubo alguna excepción a la hora de querer subir la imagen
                            throw new \Exception("mensaje", 'Ups! ocurrió un error al intentar subir el archivo.');
                        }
                        $gameFormUpload->setImage($newFileName); // Le cambio el nombre por el nuevo generado para que no se repita.
                    }
                    $campos = $form->getData(); //Guarda la data del form en $campos.
                    print_r($campos);
                    echo "Nombre:" . $gameFormUpload->getName(); //Se utiliza esta forma para obtener los datos de un input en particular, cuando a createFormBuilder se le pasa null. Con entidades es distinto.
                    die;
                }
            } else {
                $this->addFlash('css', 'danger'); //Agrego un msj flash con el css de un alert de bootstrap de color warning.
                $this->addFlash('mensaje', 'La validación de token falló.'); //Agrego un msj flash con el texto del msj que quiero mostrar.
                return $this->redirectToRoute('form_upload'); //Redirecciono a la misma vista para que se recargue la página.
            }
        }
        return $this->render('form/upload.html.twig', ['form' => $form, 'errors' => array()]);
    }
}
