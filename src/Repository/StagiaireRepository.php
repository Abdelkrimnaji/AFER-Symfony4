<?php

namespace App\Repository;

use App\Entity\Stagiaire;
use App\Entity\Licence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Stagiaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stagiaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stagiaire[]    findAll()
 * @method Stagiaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StagiaireRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Stagiaire::class);
    }

     /**
     *@param string|null $term
    * @return Stagiaire[] Returns an array of Stagiaires objects
     */
    public function findAllWithSearch(?string $term)
    {
        $qb = $this->createQueryBuilder('q')

        ->leftJoin('q.licence', 'l')
        ->addSelect('l')
        ->leftJoin('l.prefecture', 'p')
        ->addSelect('p')
        
        ->leftJoin('q.infraction', 'i')
        ->addSelect('i')
        ->leftJoin('i.natureInfraction', 'n')
        ->addSelect('n');

        if ($term) {
            $qb->andWhere('q.prenomStagiaire LIKE :term OR q.nomStagiaire LIKE :term 
            OR l.licenceNumber LIKE :term OR p.nomPrefecture LIKE :term 
            OR i.lieuInfraction LIKE :term OR n.nomInfraction LIKE :term')
            
                ->setParameter('term', '%' . $term . '%');
        }
        return $qb
        ->orderBy('q.prenomStagiaire', 'ASC')
            ->orderBy('q.nomStagiaire', 'ASC')
           
            ->getQuery()
            // ->getResult()
        ;
    }

    public function counter($value1,$value2,$value3)
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->andWhere('t.nomStagiaire = :val1')
            ->andWhere('t.prenomStagiaire = :val2')
            ->andWhere('t.dateNaissanceStagiaire = :val3')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            ->setParameter('val3', $value3)
            ->getQuery()
            ->getResult()
        ;
    }

    public function counterCivilite($civilite)
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->andWhere('t.civilite = :val')
            ->setParameter(':val', $civilite)
            ->getQuery()
            ->getResult()
        ;
    }

    // public function countTitulaire($carteJeune, $partenaire, $adherent): array
    // {
    //     $conn = $this->getEntityManager()->getConnection();

    //     $titulaire = '
    //     select (SELECT count(id) FROM stagiaire WHERE carte_jeune_stagiaire = :cartejeune) as cartejeune, (SELECT count(id) FROM stagiaire WHERE partenaire_stagiaire = :partenaire) as partenaire, (SELECT count(id) FROM stagiaire WHERE adherent_stagiaire = :adherent) as adherent
    //     ';

    //     $stmt = $conn->prepare($titulaire);
    //     $stmt->execute(['cartejeune' => $carteJeune, 'partenaire' => $partenaire, 'adherent' => $adherent]);

    //     return $stmt->fetchAll();
    // }

    // /**
    //  * @return Stagiaire[] Returns an array of Stagiaire objects
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
    public function findOneBySomeField($value): ?Stagiaire
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
