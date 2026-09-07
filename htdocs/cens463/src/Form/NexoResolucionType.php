<?php

namespace App\Form;

use App\Entity\Resolucion;
use App\Entity\Asignatura;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NexoResolucionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Campo para crear un CENS nuevo directamente
            ->add('nuevaResolucion', ResolucionType::class, [
                'required' => false,
                'label' => 'Nueva Resolucion'
            ])

            // Varias asignaturas para esa Resolucion
            ->add('asignaturas', CollectionType::class, [
                'entry_type' => NexoAsignaturaType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // No lo asociamos a una sola entidad porque este form mezcla datos
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}