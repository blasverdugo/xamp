<?php

namespace App\Form;

use App\Entity\Legajo;
use App\Entity\LibroLegajo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LibroLegajoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tomo')
            ->add('folio')
            ->add('partida')
            ->add('dni')
            ->add('tituloPrimario')
            ->add('legajo', EntityType::class, [
                'class' => Legajo::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LibroLegajo::class,
        ]);
    }
}
