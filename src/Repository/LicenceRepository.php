<?php

namespace App\Repository;

use App\Entity\Licence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Licence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Licence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Licence[]    findAll()
 * @method Licence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LicenceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Licence::class);
    }

    // /**
    //  * @return Licence[] Returns an array of Licence objects
    //  */
    

    public function counter($value1,$value2)
    {
        return $this->createQueryBuilder('l')
            ->select('count(l.id)')
            ->andWhere('l.licenceNumber = :val1')
            ->andWhere('l.licenceDate = :val2')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            ->getQuery()
            ->getResult()
        ;
    }
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Licence
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
