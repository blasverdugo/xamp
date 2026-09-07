<?php

namespace App\Form;

use App\Entity\Ciclo;
use App\Entity\Legajo;
use App\Entity\Orientada;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrientadaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha')
            ->add('legajo', EntityType::class, [
                'class' => Legajo::class,
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
            'data_class' => Orientada::class,
        ]);
    }
}
