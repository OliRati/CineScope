<?php

namespace App\Repository;

use App\Entity\Film;
use App\Entity\Platforme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Film>
 */
class FilmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Film::class);
    }

    /**
     * @return Film[] Returns an array of Film objects
     */

    public function findByPlatforme(Platforme $platforme): array
    {
        return $this->createQueryBuilder('f')->join('f.platformes', 'p')->andWhere('p = :platforme')->setParameter('platforme', $platforme)->orderBy('f.id', 'ASC')->getQuery()->getResult();
/*
        return $this->createQueryBuilder('f')
            ->andWhere('f.platforme_id = :val')
            ->setParameter('val', $platforme)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
*/
        /*
           return $this->createQueryBuilder('f')
               ->andWhere('f.platforme = :val')
               ->setParameter('val', $platforme)
               ->orderBy('f.id', 'ASC')
               ->setMaxResults(10)
               ->getQuery()
               ->getResult()
           ;
        */
    }

    //    public function findOneBySomeField($value): ?Film
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
