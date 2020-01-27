<?php
namespace App\Repository;
use App\Entity\AnimateurStatut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
/**
 * @method AnimateurStatut|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnimateurStatut|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnimateurStatut[]    findAll()
 * @method AnimateurStatut[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimateurStatutRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AnimateurStatut::class);
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
    //  * @return AnimateurStatut[] Returns an array of AnimateurStatut objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    /*
    public function findOneBySomeField($value): ?AnimateurStatut
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}