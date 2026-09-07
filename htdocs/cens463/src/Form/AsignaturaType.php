<?php

namespace App\Form;

use App\Entity\Asignatura;
use App\Entity\Ciclo;
use App\Entity\Resolucion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AsignaturaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('anio')
            ->add('duracion')
            ->add('ciclo', EntityType::class, [
                'class' => Ciclo::class,
                'choice_label' => 'id',
            ])
            ->add('resolucion', EntityType::class, [
                'class' => Resolucion::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Asignatura::class,
        ]);
    }
}
