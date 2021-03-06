<?php

namespace App\Form;

use App\Entity\Dictionnaire;
use App\Entity\Forum;
use App\Entity\Stand;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class StandType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('nom', TextType::class)
                ->add('logo', DropzoneType::class, [
                        'attr' => [
                                'placeholder' => 'Choisir un logo',
                                'data-controller' => 'mydropzone'
                        ],
                        'label' => 'Logo',
                        'multiple' => true,
                        'mapped' => false,
                        'required' => false,
                ])
                ->add('documents', DropzoneType::class, [
                        'attr' => [
                                'placeholder' => 'Choisir un document',
                                'data-controller' => 'mydropzone'
                        ],
                        'label' => 'Documents',
                        'multiple' => true,
                        'mapped' => false,
                        'required' => false,
                ])
                ->add('url', UrlType::class, [
                        'label' => 'Lien web de l\'entreprise'
                ])
                ->add('description', CKEditorType::class, [
                        'label' => 'Description de l\'entreprise'
                ])
                ->add('page_offres', CKEditorType::class, [
                        'label' => 'Description de la page des offres du stand lorsqu\'aucune offre n\'est publi??e'
                ])
                ->add('forums', EntityType::class, [
                        'class' => Forum::class,
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
                ->add('statut', ChoiceType::class, [
                        'label' => 'Statut',
                        'choices' => [
                                'Publie' => true,
                                'Non publi??' => false
                        ]
                ])
                ->add('isUne', CheckboxType::class, [
                        'label' => '?? la une?',
                    'required' => false,
                ])
                ->add('type', EntityType::class, [
                        'required' => true,
                        'label' => 'Type',
                        'expanded' => false,
                        'class' => Dictionnaire::class,
                        'query_builder' => function ($repository) {
                            $query = $repository->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_STAND);

                            return $query;
                        }
                ])
                ->add('cvtheque', ChoiceType::class, [
                        'label' => 'Cvth??que',
                        'choices' => [
                                'Oui' => true,
                                'Non' => false
                        ]
                ])
                ->add('vivierCandidat', ChoiceType::class, [
                        'label' => 'Vivier des candidats',
                        'choices' => [
                                'Oui' => true,
                                'Non' => false
                        ]
                ])
                ->add('parametresRecruteur', ChoiceType::class, [
                        'label' => 'Param??tres recruteur',
                        'choices' => [
                                'Oui' => true,
                                'Non' => false
                        ]
                ])
                ->add('speedMeeting', ChoiceType::class, [
                        'label' => 'Speed meeting',
                        'choices' => [
                                'Oui' => true,
                                'Non' => false
                        ]
                ])
                ->add('nombreParticipationCanditatStand', TextType::class, [
                        'required' => false,
                        'label' => 'Nombre de participations par candidat sur les speed-meetings du stand',
                ])
                ->add('codeInscription', TextType::class, [
                        'required' => false,
                        'label' => 'Code pour les inscriptions des ambassadeurs',
                ])
                ->add('gestionnaire', EntityType::class, [
                        'class' => User::class,
                        'multiple' => true,
                        'choice_label' => 'nom',
                        'query_builder' => function (EntityRepository $er){
                            return $er->createQueryBuilder('g')
                                    ->orderBy('g.nom', 'ASC');
                        },
                        'by_reference' => false,
                        'attr' => [
                                'class' => 'chosen-select'
                        ]
                ])
                ->add('regroupementCandidatures', ChoiceType::class, [
                        'choices' => [
                                'Non' => '0',
                                'Oui' => '1'
                        ],
                        'label' => 'Regrouper les candidatures / candidat',
                        'required' => true
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
                'data_class' => Stand::class,
        ]);
    }
}
