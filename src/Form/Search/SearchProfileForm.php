<?php

namespace App\Form\Search;

use App\Data\SearchDataProfile;
use App\Entity\Dictionnaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SearchProfileForm extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('q', TextType::class, [
                        'label' => false,
                        'required' => false,
                        'attr' => [
                                'placeholder' => 'Rechercher'
                        ]
                ])
                ->add('typeDiplome', EntityType::class, [
                        'required'  => false,
                        'label' => false,
                        'expanded' => true,
                        'multiple' => true,
                        'class' => Dictionnaire::class,
                        'query_builder' => function($repository) {
                            $query = $repository->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_DIPLOMA);

                            return $query;
                        }
                ])
                ->add('zonegeographique', EntityType::class, [
                        'required'  => false,
                        'label' => false,
                        'expanded' => true,
                        'multiple' => true,
                        'class' => Dictionnaire::class,
                        'query_builder' => function($repository) {
                            $query = $repository->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_ZONE_GEOGRAPHIQUE);

                            return $query;
                        }
                ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
                'data_class' => SearchDataProfile::class,
                'method' => 'GET',
                'csrf_protection' => false,
                'allow_extra_fields' => true
        ]);
    }

    public function getBlockPrefix(): string {
        return '';
    }

    public function getName(): string {
        return 'search_profiles';
    }
}