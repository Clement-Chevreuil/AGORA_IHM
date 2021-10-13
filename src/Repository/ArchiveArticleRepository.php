<?php

namespace App\Repository;

use App\Entity\ArchiveArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArchiveArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArchiveArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArchiveArticle[]    findAll()
 * @method ArchiveArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArchiveArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArchiveArticle::class);
    }

    // /**
    //  * @return ArchiveArticle[] Returns an array of ArchiveArticle objects
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
    public function findOneBySomeField($value): ?ArchiveArticle
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
