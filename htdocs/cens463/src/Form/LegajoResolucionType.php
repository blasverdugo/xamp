<?php

namespace App\Form;

use App\Entity\Legajo;
use App\Entity\LegajoResolucion;
use App\Entity\Resolucion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LegajoResolucionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha')
            ->add('resolucion', EntityType::class, [
                'class' => Resolucion::class,
                'choice_label' => 'id',
            ])
            ->add('legajo', EntityType::class, [
                'class' => Legajo::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LegajoResolucion::class,
        ]);
    }
}
