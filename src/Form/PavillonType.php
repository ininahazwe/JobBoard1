<?php

namespace App\Form;

use App\Entity\Dictionnaire;
use App\Entity\Forum;
use App\Entity\Pavillon;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PavillonType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('nom')
                ->add('type', EntityType::class, [
                        'required' => true,
                        'label' => 'Type',
                        'expanded' => false,
                        'class' => Dictionnaire::class,
                        'query_builder' => function ($repository) {
                            $query = $repository->createQueryBuilder('d')
                                    ->select('d')
                                    ->where('d.type = :type')
                                    ->setParameter('type', Dictionnaire::TYPE_PAVILLON);

                            return $query;
                        }
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
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
                'data_class' => Pavillon::class,
        ]);
    }
}
