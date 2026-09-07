<?php

namespace App\Form;

use App\Entity\LibroLegajo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NexoLibroLegajoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tomo')
            ->add('folio')
            ->add('partida')
            ->add('dni')
            ->add('tituloPrimario')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LibroLegajo::class,
        ]);
    }
}
