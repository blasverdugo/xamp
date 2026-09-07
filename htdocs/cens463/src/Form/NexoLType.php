<?php

namespace App\Form;

use App\Entity\Ciclo;
use App\Entity\Institucion;
use App\Entity\Legajo;
use App\Entity\Resolucion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NexoLType extends AbstractType
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('anio')
            ->add('fecha')
            ->add('turno')

            ->add('institucion', EntityType::class, [
                'class' => Institucion::class,
                'choice_label' => 'numero',
                'placeholder' => '-- Seleccione una institución --',
            ])

            ->add('resolucion', EntityType::class, [
                'class' => Resolucion::class,
                'choice_label' => 'numero',
                'choices' => [],
                'placeholder' => '-- Seleccione una resolución --',
                'required' => false,
            ])

            ->add('ciclo', EntityType::class, [
                'class' => Ciclo::class,
                'choice_label' => 'nombre',
                'choices' => [],
                'placeholder' => '-- Seleccione un ciclo --',
                'required' => false,
            ]);


        /*
         * Symfony valida EntityType contra las opciones conocidas.
         * Como resolucion y ciclo vienen por AJAX,
         * debemos agregar las entidades recibidas antes de validar.
         */
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {

            $data = $event->getData();
            $form = $event->getForm();


            if (!empty($data['resolucion'])) {

                $resolucion = $this->em
                    ->getRepository(Resolucion::class)
                    ->find($data['resolucion']);


                if ($resolucion) {
                    $form->add('resolucion', EntityType::class, [
                        'class' => Resolucion::class,
                        'choice_label' => 'numero',
                        'choices' => [$resolucion],
                        'placeholder' => '-- Seleccione una resolución --',
                        'required' => false,
                    ]);
                }
            }


            if (!empty($data['ciclo'])) {

                $ciclo = $this->em
                    ->getRepository(Ciclo::class)
                    ->find($data['ciclo']);


                if ($ciclo) {
                    $form->add('ciclo', EntityType::class, [
                        'class' => Ciclo::class,
                        'choice_label' => 'nombre',
                        'choices' => [$ciclo],
                        'placeholder' => '-- Seleccione un ciclo --',
                        'required' => false,
                    ]);
                }
            }

        });
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Legajo::class,
        ]);
    }
}