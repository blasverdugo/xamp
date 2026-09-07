<?php

namespace App\Form;

use App\Entity\Ciclo;
use App\Entity\Estudiante;
use App\Entity\Institucion;
use App\Entity\Legajo;
use App\Entity\Resolucion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LegajoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('anio')
            ->add('fecha')
            ->add('turno')
            ->add('estudiante', EntityType::class, [
                'class' => Estudiante::class,
                'choice_label' => 'id',
            ])
            ->add('institucion', EntityType::class, [
                'class' => Institucion::class,
                'choice_label' => 'id',
            ])
            ->add('resolucion', EntityType::class, [
                'class' => Resolucion::class,
                'choice_label' => 'id',
            ])
            ->add('ciclo', EntityType::class, [
                'class' => Ciclo::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Legajo::class,
        ]);
    }
}
