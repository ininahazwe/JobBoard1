<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Dictionnaire;
use App\Entity\Forum;
use App\Entity\Stand;
use Doctrine\ORM\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class AnnonceType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('nom', TextType::class, [
                    'label' => 'Nom de l\'offre',
                    'required' => false,
                ])
                ->add('reference', TextType::class, [
                        'label' => 'Référence',
                        'required' => false,
                ])
                ->add('nombre_postes', TextType::class, [
                        'label' => 'Nombre de postes',
                        'required' => false,
                ])
                ->add('description', CKEditorType::class, [
                        'label' => 'Description',
                        'required' => false,
                ])
                ->add('dateCloture', DateTimeType::class, [
                        'label' => 'Date de clôture',
                        'date_widget' => 'single_text',
                        'with_minutes' => false,
                        'with_seconds' => false
                ])
                ->add('qualites', CKEditorType::class, [
                        'label' => 'Qualités requises',
                        'required' => false,
                ])
                ->add('salaire', TextType::class, [
                        'label' => 'Salaire',
                        'required' => false,
                ])
                ->add('horaires', TextType::class, [
                        'label' => 'Horaires',
                        'required' => false,
                ])
                ->add('adresse', TextareaType::class, [
                        'label' => 'Adresse du lieu de travail',
                        'required' => false,
                ])
                ->add('avantages', TextType::class, [
                        'label' => 'Avantages',
                        'required' => false,
                ])
                ->add('accessibilite', ChoiceType::class, [
                        'label' => 'Accessibilité PMR (Personnes à mobilité réduite)',
                        'required' => false,
                        'choices' => [
                                'Oui' => true,
                                'Non' => false
                        ]
                ])
                ->add('statut', ChoiceType::class, [
                        'label' => 'Statut',
                        'required' => true,
                        'choices' => [
                                'Publié' => true,
                                'Non Publié' => false
                        ]
                ])
                ->add('forum', EntityType::class, [
                        'class' => Forum::class,
                        'required' => false,
                        'attr' => [
                                'class' => 'chosen-select'
                        ]
                ])
                ->add('stand', EntityType::class, [
                        'class' => Stand::class,
                        'required' => false,
                        'attr' => [
                                'class' => 'chosen-select'
                        ]
                ])
                ->add('zone', EntityType::class, [
                        'class' => Dictionnaire::class,
                        'label' => 'Zone géographique',
                        'multiple' => true,
                        'choice_label' => 'value',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_ZONE_GEOGRAPHIQUE);
                        },
                        'attr' => [
                                'class' => 'chosen-select'
                        ],
                        'required' => false,
                ])
                ->add('secteur', EntityType::class, [
                        'class' => Dictionnaire::class,
                        'label' => 'Secteurs d\'activité',
                        'multiple' => true,
                        'choice_label' => 'value',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_SECTEUR);
                        },
                        'attr' => [
                                'class' => 'chosen-select'
                        ],
                        'required' => false,
                ])
                ->add('diplome', EntityType::class, [
                        'class' => Dictionnaire::class,
                        'label' => 'Diplôme minimal requis',
                        'expanded' => false,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_DIPLOMA);
                        },
                        'attr' => [
                                'class' => 'chosen-select'
                        ],
                        'required' => false,
                ])
                ->add('experience', EntityType::class, [
                        'class' => Dictionnaire::class,
                        'label' => 'Expérience souhaitée',
                        'expanded' => false,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_EXPERIENCE);
                        },
                        'attr' => [
                                'class' => 'chosen-select'
                        ],
                        'required' => false,
                ])
                ->add('contrat', EntityType::class, [
                        'class' => Dictionnaire::class,
                        'label' => 'Type de contrats',
                        'expanded' => false,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_CONTRAT);
                        },
                        'attr' => [
                                'class' => 'chosen-select'
                        ],
                        'required' => false,
                ])
                ->add('documents', DropzoneType::class, [
                        'attr' => [
                                'placeholder' => 'Choisir un fichier',
                                'data-controller' => 'mydropzone'
                        ],
                        'label' => 'Document(s) complémentaire(s)',
                        'multiple' => true,
                        'mapped' => false,
                        'required' => false,
                ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
                'data_class' => Annonce::class,
        ]);
    }
}
