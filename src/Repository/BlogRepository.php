<?php

namespace App\Repository;

use App\Entity\Blog;
use App\Entity\Dictionnaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Blog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blog[]    findAll()
 * @method Blog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blog::class);
    }

    /**
     * @return mixed
     */
    public function getInterwiewType(): mixed
    {
        return $this->createQueryBuilder('b')
                ->join('b.type', 'd', 'WITH', 'd = b.type')
                ->andWhere('d.value LIKE :interview')
                ->setParameter('interview', "%interview%")
               /* ->andWhere('b.type in (ids)')
                ->setParameter('ids', $ids)*/

                ->getQuery()->getResult();
    }

    /**
     * @return mixed
     */
    public function getWebtvType(): mixed
    {
        return $this->createQueryBuilder('b')
                ->join('b.type', 'd', 'WITH', 'd = b.type')
                ->andWhere('d.value LIKE :webtv')
                ->setParameter('webtv', "%webtv%")
                /* ->andWhere('b.type in (ids)')
                 ->setParameter('ids', $ids)*/

                ->getQuery()->getResult();
    }
}
