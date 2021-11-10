<?php

namespace App\Repository;

use App\Entity\Annonce;
use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    public function getTagsAnnoncesPubliees(): array
    {
        $ids = array();
        $now = new \DateTime('now');
        $query = $this->getEntityManager()->getRepository(Annonce::class)->createQueryBuilder('a')
                ->andWhere('a.statut = 1')
                /*->andWhere('a.dateCloture > :date')
                ->setParameter('date', $now)*/

        ;
        $result = $query->getQuery()->getResult();
        foreach($result as $annonce){
            $ids[] = $annonce->getTags()->getId();
        }
        return $ids;
    }

    // /**
    //  * @return Tag[] Returns an array of Tag objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tag
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
