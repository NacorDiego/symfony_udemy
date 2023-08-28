<?php

namespace App\Form;

use App\Entity\GameFormValidation; // Importo la entidad
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameFormValidationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Name','required' => false])
            ->add('image', FileType::class, ['label' => 'Image','required' => false])
            ->add('description', TextareaType::class, ['label' => 'Description','required' => false])
            ->add('platform', ChoiceType::class, [
                'choices' => [
                    'Seleccionar...' => 0,
                    'PC' => 1,
                    'XBox' => 2,
                    'PlayStation 4' => 3,
                    'PlayStation 5' => 4,
                    'Nintendo Switch' => 5
                ],'required' => false,'placeholder' => false
            ]) // ChoiceType se utiliza para select y checkbox
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Seleccionar...' => 0,
                    'Acción' => 1,
                    'Aventura' => 2,
                    'Rol' => 3,
                    'Plataformas' => 4,
                    'Terror' => 5
                ],'required' => false,'placeholder' => false
            ])
            ->add('url', TextType::class, ['label' => 'Sitio web','required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GameFormValidation::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token'
        ]);
    }
}
