<?php

namespace App\Form;

use App\Entity\Estudiante;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstudianteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('apellido')
            ->add('nombre')
            ->add('dni')
            ->add('fecha')
            ->add('localidad')
            ->add('nacionalidad')
            ->add('genero')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Estudiante::class,
        ]);
    }
}
