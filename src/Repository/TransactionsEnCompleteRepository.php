<?php

namespace App\Repository;

use App\Entity\TransactionsEnComplete;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TransactionsEnComplete|null find($id, $lockMode = null, $lockVersion = null)
 * @method TransactionsEnComplete|null findOneBy(array $criteria, array $orderBy = null)
 * @method TransactionsEnComplete[]    findAll()
 * @method TransactionsEnComplete[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionsEnCompleteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TransactionsEnComplete::class);
    }

    // /**
    //  * @return TransactionsEnComplete[] Returns an array of TransactionsEnComplete objects
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
    public function findOneBySomeField($value): ?TransactionsEnComplete
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
