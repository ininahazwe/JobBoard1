<?php

namespace App\Form;

use App\Entity\Dictionnaire;
use App\Entity\Forum;
use App\Entity\Stand;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
                        'label' => false,
                        'multiple' => true,
                        'mapped' => false,
                        'required' => false,
                ])
                ->add('url', UrlType::class, [
                        'label' => 'Lien web de l\'entreprise'
                ])
                ->add('description', TextareaType::class, [
                        'label' => 'Description de l\'entreprise'
                ])
                ->add('page_offres', TextareaType::class, [
                        'label' => 'Description de la page des offres du stand lorsqu\'aucune offre n\'est publiée'
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
                                'Non publié' => false
                        ]
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
                        'label' => 'Cvthèque',
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
                        'label' => 'Paramètres recruteur',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
                'data_class' => Stand::class,
        ]);
    }
}
