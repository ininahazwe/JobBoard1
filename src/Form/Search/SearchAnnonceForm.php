<?php

namespace App\Form\Search;

use App\Data\SearchDataAnnonce;
use App\Entity\Dictionnaire;
use App\Entity\Tag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SearchAnnonceForm extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('q', TextType::class, [
                        'label' => false,
                        'required' => false,
                        'attr' => [
                                'placeholder' => 'Rechercher par nom, mot clé'
                        ]
                ])
                ->add('secteur', EntityType::class, [
                        'attr' => [
                                'class' => 'chosen-select'
                        ],
                        'required'  => false,
                        'label' => false,
                        'expanded' => false,
                        'multiple' => true,
                        'class' => Dictionnaire::class,
                        'query_builder' => function($repository) {
                            $query = $repository->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_SECTEUR);

                            return $query;
                        }
                ])
                ->add('diplome', EntityType::class, [
                        'attr' => [
                                'class' => 'chosen-select'
                        ],
                        'required'  => false,
                        'label' => false,
                        'expanded' => false,
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
                ->add('contrat', EntityType::class, [
                        'attr' => [
                                'class' => 'chosen-select'
                        ],
                        'required'  => false,
                        'label' => false,
                        'expanded' => false,
                        'multiple' => true,
                        'class' => Dictionnaire::class,
                        'query_builder' => function($repository) {
                            $query = $repository->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_CONTRAT);

                            return $query;
                        }
                ])
                ->add('zone', EntityType::class, [

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
                /*->add('tags', EntityType::class, [
                        'attr' => [
                                'class' => 'chosen-select'
                        ],
                        'required'  => false,
                        'label' => false,
                        'expanded' => false,
                        'multiple' => true,
                        'class' => Tag::class,
                        'query_builder' => function($repository) {
                            $ids = $repository->getTagsAnnoncesPubliees();
                            $query = $repository->createQueryBuilder('t')
                                    ->select('t')
                                    ->where('t.id IN (:ids)')
                                    ->setParameter('ids', $ids)
                            ;

                            return $query;
                        }
                ])*/
            ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
                'data_class' => SearchDataAnnonce::class,
                'method' => 'GET',
                'csrf_protection' => false,
                'allow_extra_fields' => true
        ]);
    }

    public function getBlockPrefix(): string {
        return '';
    }

    public function getName(): string {
        return 'search_annonces';
    }
}