<?php

namespace App\Form;

use App\Entity\Dictionnaire;
use App\Entity\Pavillon;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PavillonType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('nom')
                ->add('type', EntityType::class, [
                        'required' => true,
                        'label' => 'Type',
                        'expanded' => false,
                        'class' => Dictionnaire::class,
                        'query_builder' => function ($repository) {
                            $query = $repository->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_PAVILLON);

                            return $query;
                        }
                ])
                ->add('forums');
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
                'data_class' => Pavillon::class,
        ]);
    }
}
