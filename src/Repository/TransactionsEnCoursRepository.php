<?php

namespace App\Repository;

use App\Entity\TransactionsEnCours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TransactionsEnCours|null find($id, $lockMode = null, $lockVersion = null)
 * @method TransactionsEnCours|null findOneBy(array $criteria, array $orderBy = null)
 * @method TransactionsEnCours[]    findAll()
 * @method TransactionsEnCours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionsEnCoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TransactionsEnCours::class);
    }

    // /**
    //  * @return TransactionsEnCours[] Returns an array of TransactionsEnCours objects
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
    public function findOneBySomeField($value): ?TransactionsEnCours
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
