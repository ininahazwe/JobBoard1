<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    public function findAnnoncesEnFavori($user) {
        $now = new \DateTime('now');

        $query = $this->createQueryBuilder('a')
                ->andWhere('a.statut = 1')
                ->andWhere('a.date_cloture >= :date')
                ->innerJoin('a.favoris', 'u', 'WITH', 'u.id = :user')
                ->setParameter('user', $user)
                ->setParameter('date', $now);

        return $query
                ->getQuery()->getResult();
    }
}
