<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    // public function findAll()
    // {
    //     return $this->createQueryBuilder('s')
    //         // ->andWhere('s.dated >= :now')
    //         ->orderBy('s.numerostage', 'ASC')
    //         ->orderBy('s.dated', 'ASC')
    //         // ->setParameter('now', new \DateTime())
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }
/**
 * 
 */
    public function findAllQuery()
    {
        return $this->createQueryBuilder('s')
        // ->andWhere('s.dated >= :now')
        ->orderBy('s.numeroStage', 'ASC')
        ->orderBy('s.dated', 'ASC')
        
        // ->setParameter('now', new \DateTime())
        ->getQuery()
            
        ;
    }

    public function findAllToCome()
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.dated >= :now')
            ->orderBy('s.dated', 'ASC')
            ->setParameter('now', new \DateTime())
            ->getQuery()
            
        ;
    }

    public function counterLieu($value)
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->andWhere('t.lieuStage = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    public function counterStage($monthValue, $yearValue): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT count(id) FROM stage t
            WHERE MONTH(t.dated) = :month
            AND YEAR(t.dated) = :year
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['month' => $monthValue, 'year' => $yearValue]);

        return $stmt->fetchAll();
    }

    // /**
    //  * @return Stage[] Returns an array of Stage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function bordereau()
    {
        return $this->createQueryBuilder('s')
        // ->andWhere('s.dated >= :now')
        ->leftJoin('s.participations', 'p')
        ->addSelect('p')
        ->leftJoin('p.stagiaire', 'st')
        ->addSelect('st')
        
        ->leftJoin('st.infraction', 'i')
        ->addSelect('i')
        ->leftJoin('i.tribunal', 't')
        ->addSelect('t')
        
       
        ->getQuery()
        ->getResult()    
        ;
    }
}
