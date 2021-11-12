<?php

namespace App\Form;

use App\Entity\Blog;
use App\Entity\Dictionnaire;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class BlogType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('titre', TextType::class)
                ->add('isStatut', ChoiceType::class, [
                        'label' => 'Statut',
                        'choices' => [
                                'Publie' => true,
                                'Non publié' => false
                        ],
                        'attr' => [
                                'class' => 'chosen-select'
                        ]
                ])
                ->add('description', CkEditorType::class)
                ->add('type', EntityType::class, [
                        'class' => Dictionnaire::class,
                        'label' => 'Type',
                        'expanded' => false,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_BLOG);
                        },
                        'attr' => [
                                'class' => 'chosen-select'
                        ]
                ])
                ->add('faq', EntityType::class, [
                        'class' => Dictionnaire::class,
                        'label' => 'Type de faq',
                        'expanded' => false,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_FAQ_BLOG);
                        },
                        'attr' => [
                                'class' => 'chosen-select'
                        ]
                ])
                ->add('images', DropzoneType::class, [
                        'attr' => [
                                'placeholder' => 'Choisir une image',
                                'data-controller' => 'mydropzone'
                        ],
                        'label' => false,
                        'multiple' => true,
                        'mapped' => false,
                        'required' => false,
                ])
                ->add('auteur', EntityType::class, [
                        'class' => User::class,
                        'multiple' => true,
                        'choice_label' => 'nom',
                        'query_builder' => function (EntityRepository $er){
                            return $er->createQueryBuilder('u')
                                    ->orderBy('u.nom', 'ASC');
                        },
                        'by_reference' => false,
                        'attr' => [
                                'class' => 'chosen-select'
                        ]
                ])
                ->add('tag', EntityType::class, [
                        'class' => Tag::class,
                        'multiple' => true,
                        'required' => false,
                        'choice_label' => 'nom',
                        'query_builder' => function (EntityRepository $er){
                            return $er->createQueryBuilder('t')
                                    ->orderBy('t.nom', 'ASC');
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
                'data_class' => Blog::class,
        ]);
    }
}
