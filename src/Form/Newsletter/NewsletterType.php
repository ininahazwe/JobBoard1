<?php

namespace App\Form\Newsletter;

use App\Entity\Dictionnaire;
use App\Entity\Newsletter\Newsletter;
use Doctrine\ORM\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsletterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', TextType::class, [
                        'label' => 'Titre'
                ])
                ->add('content', CKEditorType::class, [
                        'label' => 'Contenu'
                ])
                ->add('categorie', EntityType::class, [
                        'class' => Dictionnaire::class,
                        'label' => 'Catégorie',
                        'multiple' => false,
                        'expanded' => true,
                        'choice_label' => 'value',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_CATEGORIE_NEWSLETTER);
                        },
                        'attr' => [
                                'class' => 'chosen-select'
                        ],
                        'required' => true,
                ])
                ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                'data_class' => Newsletter::class,
        ]);
    }
}