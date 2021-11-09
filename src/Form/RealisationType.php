<?php

namespace App\Form;

use App\Entity\Realisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class RealisationType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('nom')
                ->add('description')
                ->add('annee', DateTimeType::class, [
                        'label' => 'Date de réalisation',
                        'date_widget' => 'single_text',
                        'with_minutes' => false,
                        'with_seconds' => false
                        ])
                ->add('documents', DropzoneType::class, [
                        'attr' => [
                                'placeholder' => 'Choisir une image',
                                'data-controller' => 'mydropzone'
                        ],
                        'label' => false,
                        'multiple' => true,
                        'mapped' => false,
                        'required' => false,
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
                'data_class' => Realisation::class,
        ]);
    }
}
