<?php

namespace App\Repository;

use App\Entity\ArchiveUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArchiveUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArchiveUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArchiveUser[]    findAll()
 * @method ArchiveUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArchiveUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArchiveUser::class);
    }

    // /**
    //  * @return ArchiveUser[] Returns an array of ArchiveUser objects
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
    public function findOneBySomeField($value): ?ArchiveUser
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
