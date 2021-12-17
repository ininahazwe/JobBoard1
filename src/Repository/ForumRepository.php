<?php

namespace App\Repository;

use App\Entity\Forum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Attribute\When;

/**
 * @method Forum|null find($id, $lockMode = null, $lockVersion = null)
 * @method Forum|null findOneBy(array $criteria, array $orderBy = null)
 * @method Forum[]    findAll()
 * @method Forum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Forum::class);
    }

    public function findLastInserted(): array
    {
        $qb = $this->createQueryBuilder('f')
                ->orderBy('f.id', 'DESC')
                ->setMaxResults(1)
        ;

        $query = $qb->getQuery();

        return $query->execute();
    }
    /**
     * @param $user
     * @return mixed
     */
    public function findForumsEnFavori($user): mixed {

        $query = $this->createQueryBuilder('f')
                ->innerJoin('f.favoris_forum', 'u', 'WITH', 'u.id = :user')
                ->setParameter('user', $user)
        ;

        return $query
                ->getQuery()->getResult();
    }
}
