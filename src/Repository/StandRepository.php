<?php

namespace App\Repository;

use App\Entity\Stand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stand|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stand|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stand[]    findAll()
 * @method Stand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stand::class);
    }

    /**
     * @return array
     */
    public function findAlaUne(): array {

        $query = $this->createQueryBuilder('s')
                ->andWhere('s.isUne = 1');

        return $query->getQuery()->getResult();
    }

    /**
     * @param $user
     * @return mixed
     */
    public function findStandsEnFavori($user): mixed {

        $query = $this->createQueryBuilder('s')
                ->innerJoin('s.favoris_stand', 'u', 'WITH', 'u.id = :user')
                ->setParameter('user', $user)
                ;

        return $query
                ->getQuery()->getResult();
    }

    // /**
    //  * @return Stand[] Returns an array of Stand objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stand
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
