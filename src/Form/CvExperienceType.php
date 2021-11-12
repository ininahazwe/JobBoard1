<?php

namespace App\Form;

use App\Entity\CvExperience;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CvExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('post', TextType::class)
            ->add('entreprise')
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
            ->add('description', CkEditorType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CvExperience::class,
        ]);
    }
}
