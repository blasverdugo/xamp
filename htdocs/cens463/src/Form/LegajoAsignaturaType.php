<?php

namespace App\Form;

use App\Entity\Asignatura;
use App\Entity\Legajo;
use App\Entity\LegajoAsignatura;
use App\Entity\LegajoResolucion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LegajoAsignaturaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('legajo', EntityType::class, [
                'class' => Legajo::class,
                'choice_label' => 'id',
            ])
            ->add('asignatura', EntityType::class, [
                'class' => Asignatura::class,
                'choice_label' => 'id',
            ])
            ->add('legajoResolucion', EntityType::class, [
                'class' => LegajoResolucion::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LegajoAsignatura::class,
        ]);
    }
}
