<?php
namespace App\Repository;
use App\Entity\Animateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
/**
 * @method Animateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Animateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Animateur[]    findAll()
 * @method Animateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimateurRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Animateur::class);
    }

    public function counterFonction($value)
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->andWhere('t.animateurFonction = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    public function counter($value1,$value2,$value3)
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->andWhere('t.nomAnimateur = :val1')
            ->andWhere('t.prenomAnimateur = :val2')
            ->andWhere('t.siretAnimateur = :val3')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            ->setParameter('val3', $value3)
            ->getQuery()
            ->getResult()
        ;
    }

    public function counterStatut($value)
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->andWhere('t.animateurStatut = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Animateur[] Returns an array of Animateur objects
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
    public function findOneBySomeField($value): ?Animateur
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