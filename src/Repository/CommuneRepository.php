<?php

namespace App\Repository;

use App\Entity\Commune;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Commune|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commune|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commune[]    findAll()
 * @method Commune[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommuneRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Commune::class);
    }

    /**
     * @Return Commune[]
     */


    public function findCommunes($commune)
    {

        return $this->createQueryBuilder('c')
            ->where('c.nomCommune LIKE :commune')
            ->setParameter('commune', $commune.'%')
            ->orderBy('c.nomCommune')
            ->getQuery()
            ->getArrayResult()
        ;
    }
    

    
}
