<?php

namespace App\Repository;

use App\Entity\CvFormation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CvFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method CvFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method CvFormation[]    findAll()
 * @method CvFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CvFormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CvFormation::class);
    }

    // /**
    //  * @return CvFormation[] Returns an array of CvFormation objects
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
    public function findOneBySomeField($value): ?CvFormation
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
