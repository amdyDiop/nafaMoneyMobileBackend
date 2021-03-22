<?php

namespace App\Repository;

use App\Entity\Agences;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Agences|null find($id, $lockMode = null, $lockVersion = null)
 * @method Agences|null findOneBy(array $criteria, array $orderBy = null)
 * @method Agences[]    findAll()
 * @method Agences[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgencesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Agences::class);
    }

    // /**
    //  * @return Agences[] Returns an array of Agences objects
    //  */

    public function findByUser($telephone)
    {
        return $this->createQueryBuilder('a')
            ->join('a.userAgence ','uAgence')
            ->andWhere('uAgence.telephone = :telephone')
            ->setParameter('telephone', $telephone)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Agences
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
