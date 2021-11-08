<?php

namespace App\Form;

use App\Entity\CvFormation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CvFormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('etablissement', TextType::class)
                ->add('debut', DateTimeType::class, [
                        'date_widget' => 'single_text',
                        'label' => 'Date de début',
                        'with_minutes' => false,
                        'with_seconds' => false
                ])
                ->add('fin', DateTimeType::class, [
                        'date_widget' => 'single_text',
                        'label' => 'Date de fin',
                        'with_minutes' => false,
                        'with_seconds' => false
                ])
            ->add('description', TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CvFormation::class,
        ]);
    }
}
