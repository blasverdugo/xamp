<?php

namespace App\Form;

use App\Entity\Estudiante;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class NexoLegajoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('estudiante', EstudianteType::class, [
                'required' => true,
            ])
            ->add('legajo', NexoLType::class, [
                'required' => true,
            ])
            ->add('estudioPrimario', NexoEPType::class, [
                'required' => false,
            ])
            ->add('estudioSecundario', NexoESType::class, [
                'required' => false,
            ])
            ->add('libroLegajo', NexoLibroLegajoType::class, [
                'required' => false,
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}