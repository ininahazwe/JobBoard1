<?php

namespace App\Repository;

use App\Entity\File;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method File|null find($id, $lockMode = null, $lockVersion = null)
 * @method File|null findOneBy(array $criteria, array $orderBy = null)
 * @method File[]    findAll()
 * @method File[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, File::class);
    }


    /**
     * @param $user
     * @return QueryBuilder
     */
    public function getCVByCandidat($user): QueryBuilder {
        $query = $this->createQueryBuilder('f');

            $query
                    ->where('f.type= :cv')
                    ->andWhere('f.profile = :profile')
                    ->setParameter('cv', File::TYPE_CV)
                    ->setParameter('profile', $user->getProfile())
                    ->getQuery();

            return $query;

    }



    public function getAllCVProfiles(): QueryBuilder {

       // $profile = $user->getProfile();
        $query = $this->createQueryBuilder('f');

        $query
                //->select('f.id')
                //->orderBy('f.createdAt', 'DESC')
                ->andWhere('f.type = :type')
                //->andWhere('f.profile = :profile')
                ->setParameter('type', File::TYPE_CV)
               //->setParameter('profile', $profile)
                ->getQuery()
                //->getResult()
        ;

        return $query;

    }




    // /**
    //  * @return File[] Returns an array of File objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?File
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
