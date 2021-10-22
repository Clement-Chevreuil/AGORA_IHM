<?php

namespace App\Repository;

use App\Entity\ArchiveSupport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArchiveSupport|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArchiveSupport|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArchiveSupport[]    findAll()
 * @method ArchiveSupport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArchiveSupportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArchiveSupport::class);
    }

    // /**
    //  * @return ArchiveSupport[] Returns an array of ArchiveSupport objects
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
    public function findOneBySomeField($value): ?ArchiveSupport
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
