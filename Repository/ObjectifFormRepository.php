<?php

namespace App\Repository;

use App\Entity\ObjectifForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ObjectifForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObjectifForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObjectifForm[]    findAll()
 * @method ObjectifForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjectifFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObjectifForm::class);
    }

    // /**
    //  * @return ObjectifForm[] Returns an array of ObjectifForm objects
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
    public function findOneBySomeField($value): ?ObjectifForm
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
