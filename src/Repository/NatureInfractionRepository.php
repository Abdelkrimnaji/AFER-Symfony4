<?php

namespace App\Repository;

use App\Entity\NatureInfraction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NatureInfraction|null find($id, $lockMode = null, $lockVersion = null)
 * @method NatureInfraction|null findOneBy(array $criteria, array $orderBy = null)
 * @method NatureInfraction[]    findAll()
 * @method NatureInfraction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NatureInfractionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NatureInfraction::class);
    }

    // /**
    //  * @return NatureInfraction[] Returns an array of NatureInfraction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NatureInfraction
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
