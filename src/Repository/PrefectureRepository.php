<?php

namespace App\Repository;

use App\Entity\Prefecture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Prefecture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prefecture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prefecture[]    findAll()
 * @method Prefecture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrefectureRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Prefecture::class);
    }

    public function counter($value1,$value2)
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->andWhere('t.nomPrefecture = :val1')
            ->andWhere('t.communePrefecture = :val2')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            ->getQuery()
            ->getResult()
        ;
    }

    public function counterAutorite($value)
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->andWhere('t.prefectureAutorite = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    public function counterService($value)
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->andWhere('t.prefectureService = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Prefecture[] Returns an array of Prefecture objects
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
    public function findOneBySomeField($value): ?Prefecture
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
