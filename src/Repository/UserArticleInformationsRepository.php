<?php

namespace App\Repository;
use App\Entity\Article;
use App\Entity\User;
use App\Entity\UserArticleInformations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserArticleInformations|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserArticleInformations|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserArticleInformations[]    findAll()
 * @method UserArticleInformations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserArticleInformationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserArticleInformations::class);
    }

   
    public function findUserArticleInformations(int $idUser, int $idArticle)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT a
            FROM App\Entity\UserArticleInformations a 
            WHERE a.user = :idUser
            AND a.article = :idArticle'
        )->setParameter('idUser', $idUser)->setParameter('idArticle', $idArticle);

        // returns an array of Product objects
        return $query->getResult();
    }

    // /**
    //  * @return UserArticleInformations[] Returns an array of UserArticleInformations objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?UserArticleInformations
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
