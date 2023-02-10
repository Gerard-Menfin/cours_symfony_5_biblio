<?php

namespace App\Repository;

use App\Entity\Emprunt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Emprunt|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emprunt|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emprunt[]    findAll()
 * @method Emprunt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmpruntRepository extends Depot
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emprunt::class);
    }

    /**
     * Retourne la liste des emprunts concernant les livres de l'auteur passé en paramètre
     */
    public function findEmpruntsParAuteur($auteur){
        return $this->createQueryBuilder('e')
            ->join("e.livre", "l")
            ->where('l.auteur = :val')
            ->setParameter('val', $auteur)
            ->orderBy('e.date_emprunt', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findChloe()
    {
        return $this->createQueryBuilder('e')
            ->join("e.abonne", "a")
            ->where('a.pseudo = :val')
            ->setParameter('val', "Chloe")
            ->orderBy('e.date_emprunt', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findLivresEmpruntesPar($pseudo)
    {
        return $this->createQueryBuilder('e')
            ->join("e.abonne", "a")
            ->where('a.pseudo = :val')
            ->setParameter('val', $pseudo)
            ->orderBy('e.date_emprunt', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByNonRendus()
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.date_retour IS NULL')
            ->orderBy('e.date_emprunt', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }





    // /**
    //  * @return Emprunt[] Returns an array of Emprunt objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Emprunt
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
