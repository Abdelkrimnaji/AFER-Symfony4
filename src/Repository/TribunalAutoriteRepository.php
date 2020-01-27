<?php

namespace App\Repository;

use App\Entity\TribunalAutorite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TribunalAutorite|null find($id, $lockMode = null, $lockVersion = null)
 * @method TribunalAutorite|null findOneBy(array $criteria, array $orderBy = null)
 * @method TribunalAutorite[]    findAll()
 * @method TribunalAutorite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TribunalAutoriteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TribunalAutorite::class);
    }

    /**
    * @return TribunalAutorite[] Returns an array of TribunalAutorite objects
    */

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


    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TribunalAutorite
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
