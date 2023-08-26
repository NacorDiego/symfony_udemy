<?php

namespace App\Form;

use App\Entity\GameForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder //Acá se construye el formulario
            ->add('name',TextType::class, ['label'=>'Name'])
            ->add('image',TextType::class,['label'=>'Image'])
            ->add('description',TextareaType::class,['label'=>'Description'])
            ->add('platform',ChoiceType::class,[
                'choices'=>[
                    'PC'=>1,
                    'XBox'=>2,
                    'PlayStation 4'=>3,
                    'PlayStation 5'=>4,
                    'Nintendo Switch'=>5
                ],'placeholder'=>'Seleccionar...'
            ]) // ChoiceType se utiliza para select y checkbox
            ->add('gender',ChoiceType::class,[
                'choices'=>[
                    'Acción'=>1,
                    'Aventura'=>2,
                    'Rol'=>3,
                    'Plataformas'=>4,
                    'Terror'=>5
                ],'placeholder'=>'Seleccionar...'
            ])
            ->add('url',UrlType::class,['label'=>'Sitio web'])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GameForm::class, // Asocio el formulario a la entidad 'GameForm'
            'csrf_protection' => true, // Activo la protección forzada para el filtro csrf.
            'csrf_field_name' => '_token', // Utilizo las dos lineas para habilitarlo.
        ]);
    }
}
