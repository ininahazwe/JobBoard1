<?php

namespace App\Repository;

use App\Data\SearchDataProfile;
use App\Entity\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Profile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profile[]    findAll()
 * @method Profile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileRepository extends ServiceEntityRepository
{
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator) {
        parent::__construct($registry, Profile::class);
        $this->paginator = $paginator;
    }

    /**
     * @return mixed
     */
    public function findAllCandidates(): mixed
    {
        return $this->createQueryBuilder('p')
                ->orderBy('p.user.role', 'ASC')
                ->andWhere('p.user.role IN (:roles)')
                ->setParameter('role', 'ROLE_CANDIDAT')
                ->getQuery()->getResult();
    }

    /**
     * @param SearchDataProfile $search
     * @return PaginationInterface
     */
    public function findSearch(SearchDataProfile $search): PaginationInterface {
        $query = $this->getSearchQuery($search)->getQuery();
        return $this->paginator->paginate(
                $query,
                $search->page,
                1
        );
    }

    public function getSearchQuery(SearchDataProfile $search): QueryBuilder {
        $query = $this
                ->createQueryBuilder('p');
        ;

        if (!empty($search->q)) {
            $query
                    ->innerJoin('p.user', 'u' )
                    ->andWhere("CONCAT(u.nom, ' ', u.prenom) LIKE :q OR u.email LIKE :q OR p.description LIKE :q")
                    ->setParameter('q', "%" . $search->q . "%");
        }
        if(!empty($search->typeDiplome)){
/*            $idsDiplomas = array();
            foreach($search->typeDiplome as $diplome){
                $idsDiplomas[] = $diplome->getId();
            }*/

            $query = $query
                    ->innerJoin('p.typeDiplome', 'd')
                    ->andWhere('d.id IN (:typeDiplome)')
                    ->setParameter('typeDiplome', $search->typeDiplome);
        }
        if(!empty($search->zonegeographique)){
            $query = $query
                    ->innerJoin('p.zonegeographique', 'd')
                    ->andWhere('d.id IN (:zonegeographique)')
                    ->setParameter('zonegeographique', $search->zonegeographique);
        }
        return $query;
    }
}
