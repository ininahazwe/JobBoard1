<?php

namespace App\Repository;

use App\Entity\CvExperience;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CvExperience|null find($id, $lockMode = null, $lockVersion = null)
 * @method CvExperience|null findOneBy(array $criteria, array $orderBy = null)
 * @method CvExperience[]    findAll()
 * @method CvExperience[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CvExperienceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CvExperience::class);
    }

    // /**
    //  * @return CvExperience[] Returns an array of CvExperience objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CvExperience
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
