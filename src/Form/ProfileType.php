<?php

namespace App\Form;

use App\Entity\CvExperience;
use App\Entity\CvFormation;
use App\Entity\Dictionnaire;
use App\Entity\Profile;
use App\Entity\Tag;
use Doctrine\ORM\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class ProfileType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('description', CKEditorType::class, [
                        'label' => 'Description',
                        'required' => false
                ])
                ->add('lien_video', TextType::class, [
                        'label' => 'Lien vidéo',
                        'required' => false
                ])
                ->add('ville', TextType::class, [
                        'label' => 'Ville',
                ])
                ->add('codePostal', TextType::class, [
                        'label' => 'Code postal',
                ])
                ->add('dateNaissance', DateTimeType::class, [
                        'date_widget' => 'single_text',
                        'with_minutes' => false,
                        'with_seconds' => false
                ])
                ->add('photo', DropzoneType::class, [
                        'attr' => [
                                'placeholder' => 'Choisir une image',
                                'data-controller' => 'mydropzone'
                        ],
                        'label' => false,
                        'multiple' => true,
                        'mapped' => false,
                        'required' => false,
                ])
                ->add('cv', DropzoneType::class, [
                        'attr' => [
                                'placeholder' => 'Choisir un fichier',
                                'data-controller' => 'mydropzone'
                        ],
                        'label' => false,
                        'multiple' => true,
                        'mapped' => false,
                        'required' => false,
                ])
                ->add('isRqth', CheckboxType::class, [
                        'label_attr' => ['class' => 'switch'],
                        'required' => false,
                        'label' => 'RQTH ?',
                ])
                ->add('isVisible', CheckboxType::class, [
                        'label_attr' => ['class' => 'switch'],
                        'required' => false,
                        'label' => 'Visibilité ?',
                ])
                ->add('isAmenagement', CheckboxType::class, [
                        'label_attr' => ['class' => 'checkboxes square'],
                        'required' => false,
                        'label' => 'Aménagement nécessaire ?',
                ])
                ->add('portfolio', TextType::class)
                ->add('telephone', NumberType::class)
                ->add('recevoirAlertesOffres', CheckboxType::class, [
                        'label_attr' => ['class' => 'switch'],
                        'required' => false
                ])
                ->add('isCvtheque', CheckboxType::class, [
                        'label_attr' => ['class' => 'switch'],
                        'required' => false
                ])
                ->add('isRecevoirAlertes', CheckboxType::class, [
                        'label_attr' => ['class' => 'switch'],
                        'required' => false
                ])
                ->add('isConditionsUtilisation', CheckboxType::class, [
                        'label_attr' => ['class' => 'switch'],
                        'required' => false
                ])
                ->add('typeContrat', EntityType::class, [
                        'class' => Dictionnaire::class,
                        'label' => 'Type de contrat',
                        'expanded' => false,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_CONTRAT);
                        },
                        'attr' => [
                                'class' => 'chosen-select'
                        ]
                ])
                ->add('typeDiplome', EntityType::class, [
                        'attr' => [
                                'class' => 'chosen-select'
                        ],
                        'required' => true,
                        'label' => 'Type de diplôme',
                        'expanded' => false,
                        'class' => Dictionnaire::class,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_DIPLOMA);
                        }
                ])
                ->add('secteurActivite', EntityType::class, [
                        'attr' => [
                                'class' => 'chosen-select'
                        ],
                        'required' => true,
                        'label' => 'Secteur d\'activité',
                        'expanded' => false,
                        'class' => Dictionnaire::class,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_SECTEUR);
                        }
                ])
                ->add('typeEntretien', EntityType::class, [
                        'attr' => [
                                'class' => 'chosen-select'
                        ],
                        'required' => true,
                        'label' => 'Type d\'entretien',
                        'expanded' => false,
                        'class' => Dictionnaire::class,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_ENTRETIEN);
                        }
                ])
                ->add('langues', EntityType::class, [
                        'attr' => [
                                'class' => 'chosen-select'
                        ],
                        'required' => true,
                        'label' => 'Langues',
                        'expanded' => false,
                        'class' => Dictionnaire::class,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_LANGUAGE);
                        }
                ])
                ->add('zonegeographique', EntityType::class, [
                        'attr' => [
                                'class' => 'chosen-select'
                        ],
                        'required' => true,
                        'label' => 'Zone géographique',
                        'expanded' => false,
                        'class' => Dictionnaire::class,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_ZONE_GEOGRAPHIQUE);
                        }
                ])
                ->add('experiences', EntityType::class, [
                        'attr' => [
                                'class' => 'chosen-select'
                        ],
                        'required' => true,
                        'label' => 'Experiences',
                        'expanded' => false,
                        'class' => Dictionnaire::class,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_EXPERIENCE);
                        }
                ])
                ->add('cvexperiences', EntityType::class, [
                        'class' => CvExperience::class,
                        'multiple' => true,
                        'required' => false,
                        'choice_label' => 'post',
                        'label' => 'Experiences professionnelles',
                        'expanded' => false,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('c')
                                    ->orderBy('c.post', 'ASC');
                        },
                        'by_reference' => false,
                        'attr' => [
                                'class' => 'chosen-select'
                        ]

                ])
                ->add('cvformations', EntityType::class, [
                        'class' => CvFormation::class,
                        'multiple' => true,
                        'required' => false,
                        'choice_label' => 'nom',
                        'label' => 'Formations',
                        'expanded' => false,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('c')
                                    ->orderBy('c.nom', 'ASC');
                        },
                        'by_reference' => false,
                        'attr' => [
                                'class' => 'chosen-select'
                        ]

                ])
                ->add('tags', EntityType::class, [
                    'class' => Tag::class,
                    'multiple' => true,
                    'required' => false,
                    'choice_label' => 'nom',

                    'query_builder' => function(EntityRepository $er){
                        return $er->createQueryBuilder('t')
                                ->orderBy('t.nom', 'ASC');
                    },
                    'label' => 'Tags',
                    'by_reference' => false,
                    'attr' => [
                            'class' => 'chosen-select'
                    ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
                'csrf_protection' => false,
                'data_class' => Profile::class,
        ]);
    }
}
