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

    public function findBySearch(array $params)
    {
        /*$qb = $this->_em->createQueryBuilder()->select('a.title')->from(Annonce::class, 'a');

        dd($qb->getQuery()->getResult());*/

        // on créer QueryBuilder qui va nous permettre d'écrire une requête
        $qb = $this->createQueryBuilder('a');

        if (isset($params['betterThan'])) {
            $qb
                ->andWhere('a.status >= :status')
                ->setParameter('status', $params['betterThan']);
        }

        if (isset($params['newerThan'])) {
            $qb
                ->andWhere('a.createdAt >= :createdAt')
                ->setParameter('createdAt', $params['newerThan']);
        }

        $qb->addOrderBy('a.createdAt', 'DESC');

        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return Annonce[] Returns an array of Annonce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Annonce
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
