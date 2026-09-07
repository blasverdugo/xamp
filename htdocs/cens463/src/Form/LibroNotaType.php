<?php

namespace App\Form;

use App\Entity\Legajo;
use App\Entity\LegajoAsignatura;
use App\Entity\LibroNota;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LibroNotaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nota')
            ->add('fecha')
            ->add('tomo')
            ->add('folio')
            ->add('observaciones')
            ->add('legajoAsignatura', EntityType::class, [
                'class' => LegajoAsignatura::class,
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
            'data_class' => LibroNota::class,
        ]);
    }
}
