<?php

namespace App\Repository;

use App\Data\SearchDataAnnonce;
use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator) {
        parent::__construct($registry, Annonce::class);
        $this->paginator = $paginator;
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

    /**
     * @param SearchDataAnnonce $search
     * @return PaginationInterface
     */
    public function findSearch(SearchDataAnnonce $search): PaginationInterface {
        $query = $this->getSearchQuery($search)->getQuery();
        return $this->paginator->paginate(
                $query,
                $search->page,
                10
        );
    }

    public function getSearchQuery(SearchDataAnnonce $search): QueryBuilder {
        $query = $this
                ->createQueryBuilder('a');
        ;

        if(!empty($search->q)){
            $query
                    ->andWhere('a.nom LIKE :q')
                    ->setParameter('q', "%" . $search->q . "%");
        }
        if(!empty($search->zone)){
            $query = $query
                    ->innerJoin('a.zone', 'd')
                    ->andWhere('d.id IN (:zone)')
                    ->setParameter('zone', $search->zone);
        }

        if(!empty($search->contrat)){
            $query = $query
                    ->innerJoin('a.contrat', 'd')
                    ->andWhere('d.id IN (:contrat)')
                    ->setParameter('contrat', $search->contrat);
        }

        if(!empty($search->diplome)){
            $query = $query
                    ->innerJoin('a.diplome', 'd')
                    ->andWhere('d.id IN (:diplome)')
                    ->setParameter('diplome', $search->diplome);
        }

        if(!empty($search->secteur)){
            $query = $query
                    ->innerJoin('a.secteur', 'd')
                    ->andWhere('d.id IN (:secteur)')
                    ->setParameter('secteur', $search->secteur);
        }

        if(!empty($search->tags)){
            $query = $query
                    ->innerJoin('a.tags', 't')
                    ->andWhere('t.id IN (:tags)')
                    ->setParameter('tags', $search->tags);
        }

        return $query;
    }
}
