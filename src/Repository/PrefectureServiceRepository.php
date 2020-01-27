<?php

namespace App\Repository;

use App\Entity\PrefectureService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PrefectureService|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrefectureService|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrefectureService[]    findAll()
 * @method PrefectureService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrefectureServiceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PrefectureService::class);
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
    //  * @return PrefectureService[] Returns an array of PrefectureService objects
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
    public function findOneBySomeField($value): ?PrefectureService
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
