<?php

namespace App\Form;

use App\Entity\EstudioSecundario;
use App\Entity\Legajo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstudioSecundarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tomo')
            ->add('folio')
            ->add('fecha')
            ->add('tipo')
            ->add('numero')
            ->add('localidad')
            ->add('anioCompleto')
            ->add('planEstudio')
            ->add('legajo', EntityType::class, [
                'class' => Legajo::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EstudioSecundario::class,
        ]);
    }
}
