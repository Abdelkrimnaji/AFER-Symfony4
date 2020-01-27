<?php

namespace App\Repository;

use App\Entity\Infraction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Infraction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Infraction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Infraction[]    findAll()
 * @method Infraction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfractionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Infraction::class);
    }

    // /**
    //  * @return Infraction[] Returns an array of Infraction objects
    //  */


    public function counter($value1,$value2)
    {
        return $this->createQueryBuilder('i')
            ->select('count(i.id)')
            ->andWhere('i.lieuInfraction = :val1')
            ->andWhere('i.dateInfraction = :val2')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Infraction
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
