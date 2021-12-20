<?php

namespace App\Form\Newsletter;

use App\Entity\Dictionnaire;
use App\Entity\Newsletter\Users;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class NewsletterUsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('email', EmailType::class)
                ->add('categorie', EntityType::class, [
                        'class' => Dictionnaire::class,
                        'label' => 'Catégorie',
                        'multiple' => true,
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
                ->add('is_rgpd', CheckboxType::class, [
                        'constraints' => [
                                new IsTrue([
                                        'message' => 'Vous devez accepter la collecte de vos données personnelles'
                                ])
                        ],
                        'label' => 'J\'accepte la collecte de mes données personnelles'
                ])
                ->add('envoyer', SubmitType::class, [
                        'attr' => [
                                'class' => 'theme-btn btn-style-one small'
                        ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                'data_class' => Users::class,
        ]);
    }
}