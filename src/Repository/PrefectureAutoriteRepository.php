<?php

namespace App\Repository;

use App\Entity\PrefectureAutorite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PrefectureAutorite|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrefectureAutorite|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrefectureAutorite[]    findAll()
 * @method PrefectureAutorite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrefectureAutoriteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PrefectureAutorite::class);
    }

    public function counter($value)
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->andWhere('t.nom = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return PrefectureAutorite[] Returns an array of PrefectureAutorite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PrefectureAutorite
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
