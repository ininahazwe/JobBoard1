<?php

namespace App\Form;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class CvType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder

                ->add('cv', DropzoneType::class, [
                        'attr' => [
                                'placeholder' => 'Choisir un fichier',
                                'data-controller' => 'mydropzone'
                        ],
                        'label' => false,
                        'multiple' => true,
                        'mapped' => false,
                        'required' => true,
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
                'csrf_protection' => false,
                'data_class' => Profile::class,
        ]);
    }

}
