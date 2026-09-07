<?php

namespace App\Form;

use App\Entity\EstudioSecundario;
use App\Entity\Legajo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NexoESType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha')
            ->add('tipo')
            ->add('numero')
            ->add('localidad')
            ->add('anioCompleto')
            ->add('planEstudio')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EstudioSecundario::class,
        ]);
    }
}
