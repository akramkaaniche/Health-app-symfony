<?php

namespace App\Repository;

use App\Entity\Objectif;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Objectif|null find($id, $lockMode = null, $lockVersion = null)
 * @method Objectif|null findOneBy(array $criteria, array $orderBy = null)
 * @method Objectif[]    findAll()
 * @method Objectif[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjectifRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Objectif::class);
    }

    /**
     * Returns numnber of "objectifs" par jour
     */
    public function countByDate(){
        $query = $this->createQueryBuilder('a')
        ->select('a.datedebut, count(a) as count')
            ->groupBy('a.datedebut')
            ;
        return $query->getQuery()->getResult();
    }

    public function listObjOrderByDesc()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.description','DESC ')
            ->getQuery()->getResult();
    }

    public function listObjOrderByRep()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.reponse','DESC ')
            ->getQuery()->getResult();
    }
    public function listObjOrderByDate()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.datedebut','DESC ')
            ->getQuery()->getResult();
    }

    // /**
    //  * @return Objectif[] Returns an array of Objectif objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Objectif
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
