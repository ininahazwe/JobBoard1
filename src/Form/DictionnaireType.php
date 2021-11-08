<?php

namespace App\Form;

use App\Entity\Dictionnaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DictionnaireType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('type', ChoiceType::class, [
                        'choices' => Dictionnaire::getTypeList(),
                        'attr' => [
                                'class' => 'chosen-select'
                        ],
                        'required' => false
                ])
                ->add('value');
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
                'data_class' => Dictionnaire::class,
        ]);
    }
}
