<?php

namespace App\Repository;

use App\Entity\Participation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Participation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participation[]    findAll()
 * @method Participation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Participation::class);
    }

    // /**
    //  * @return Participation[] Returns an array of Participation objects
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


    public function findAllByvalue($value1, $value2)
    {
        return $this->createQueryBuilder('p')
        
            ->andWhere('p.stage = :val1')
            ->andWhere('p.stagiaire = :val2')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            ->getQuery()
            ->getResult()
        ;
    }
    
}
