<?php

namespace App\Form;

use App\Entity\Dictionnaire;
use App\Entity\Forum;
use App\Entity\Pavillon;
use App\Entity\Stand;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class ForumType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('nom')
                ->add('stand', EntityType::class, [
                        'class' => Stand::class,
                        'multiple' => true,
                        'choice_label' => 'nom',
                        'query_builder' => function (EntityRepository $er){
                            return $er->createQueryBuilder('f')
                                    ->orderBy('f.nom', 'ASC');
                        },
                        'by_reference' => false,
                        'attr' => [
                                'class' => 'chosen-select'
                        ]
                ])
                ->add('logo', DropzoneType::class, [
                        'attr' => [
                                'placeholder' => 'Choisir une image d\'illustration',
                                'data-controller' => 'mydropzone'
                        ],
                        'label' => false,
                        'multiple' => true,
                        'mapped' => false,
                        'required' => false,
                ])
                ->add('dateOuverture',DateTimeType::class, [
                        'date_widget' => 'single_text',
                        'with_minutes' => false,
                        'with_seconds' => false
                ])
                ->add('dateFermeture',DateTimeType::class, [
                        'date_widget' => 'single_text',
                        'with_minutes' => false,
                        'with_seconds' => false
                ])
                ->add('statut', ChoiceType::class, [
                        'attr' => [
                             'class' => 'chosen-select'
                        ],
                        'choices' => [
                                'Publie' => true,
                            'Non publié' => false
                        ]
                ])
                ->add('date_fermeture_candidature',DateTimeType::class, [
                        'date_widget' => 'single_text',
                        'with_minutes' => false,
                        'with_seconds' => false
                ])
                ->add('description')
                ->add('openingStatut', EntityType::class, [
                        'required' => true,
                        'label' => 'Statut d\'ouverture',
                        'expanded' => false,
                        'class' => Dictionnaire::class,
                        'query_builder' => function ($repository) {
                            $query = $repository->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_FORUM_OPENING_STATUS);

                            return $query;
                        }
                ])
                ->add('pavillon', EntityType::class, [
                        'class' => Pavillon::class,
                        'required' => false,
                        'multiple' => true,
                        'choice_label' => 'nom',
                        'query_builder' => function (EntityRepository $er){
                            return $er->createQueryBuilder('f')
                                    ->orderBy('f.nom', 'ASC');
                        },
                        'by_reference' => false,
                        'attr' => [
                                'class' => 'chosen-select'
                        ]
                ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
                'data_class' => Forum::class,
        ]);
    }
}
