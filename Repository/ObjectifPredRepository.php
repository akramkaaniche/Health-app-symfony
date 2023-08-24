<?php

namespace App\Repository;

use App\Entity\ObjectifPred;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ObjectifPred|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObjectifPred|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObjectifPred[]    findAll()
 * @method ObjectifPred[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjectifPredRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObjectifPred::class);
    }

    public function listObjOrderByDuree()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.duree','DESC ')
            ->getQuery()->getResult();
    }
    public function listObjOrderByDesc()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.description','DESC ')
            ->getQuery()->getResult();
    }

    // /**
    //  * @return ObjectifPred[] Returns an array of ObjectifPred objects
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
    public function findOneBySomeField($value): ?ObjectifPred
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
