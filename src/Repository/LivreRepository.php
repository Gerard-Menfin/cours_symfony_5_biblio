<?php

namespace App\Repository;

use App\Entity\Emprunt;
use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }
    /**
     * @return Livre[] Retourne les livres qui n'ont pas été rendus
     * 
     */
    public function findLivresEmpruntes()
    {
        /*
        SELECT l.*
        FROM livre l JOIN emprunt e ON l.id = e.livre_id
        WHERE e.date_retour IS NULL
        ORDER BY l.auteur ASC, l.titre
        */
        return $this->createQueryBuilder('l')
            ->join(Emprunt::class, "e", "WITH", "l.id = e.livre")
            ->where('e.date_retour IS NULL')
            ->select("l")
            ->orderBy('l.auteur', 'ASC')
            ->addOrderBy("l.titre")
            ->getQuery()
            ->getResult()
        ;
    }

        /**
     * Requête avec jointure : livres empruntés non rendus
     * @return Array of App\Entity\Livre object
     */
    public function findByEmpruntes()
    {
        return $this->createQueryBuilder('l')
            ->join(Emprunt::class, "e", "WITH", "e.livre=l.id")
            ->andWhere('e.date_rendu IS NULL')
            ->orderBy('l.auteur', 'ASC')
            ->addOrderBy('l.titre')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Nombre de livres empruntés actuellement
     * SELECT COUNT(*)
     * FROM livre l
     *  JOIN emprunt e ON l.id = e.livre_id
     * WHERE e.date_rendu IS NULL
     * @return integer
     */
    public function nbSortis() : int
    {
        $requete = $this->createQueryBuilder("l")
                        ->select("COUNT(l.id) as nb")
                        ->join("App\Entity\Emprunt", "e", "WITH", "e.livre=l.id")
                        ->andWhere('e.date_rendu IS NULL')
                        ->getQuery()
                        ->getOneOrNullResult();
        return $requete ? (int)$requete["nb"] : 0;
    }

    /**
     * Nombre de livres disponibles
     * @return integer
     */
    public function nbDisponibles() : int
    {
        return $this->nb() - $this->nbSortis();
    }

    /**
     * Livres les plus emprunts
     * Requête SQL :
     *  SELECT l.titre, COUNT(*) AS nb
     *  FROM livre l
     *   JOIN emprunt e ON l.id = e.livre_id
     *  GROUP BY l.titre
     *  ORDER BY nb DESC, l.titre ASC
     * 
     * @param $max integer
     */
    public function lesPlusEmpruntes($max=0)
    {
        // NB : s'il n'y a pas de champ reliant les deux entités dans l'entité du Repository actuel
        //      il faut préciser les champs liés (? le mot ON ne fonctionne pas)
        // NB : dans la méthode select l équivaut à l.*
        $requete = $this->createQueryBuilder("l")
                        ->join(Emprunt::class, "e", "WITH", "l.id = e.livre")
                        ->groupBy("l.titre")
                        ->select("l AS livre, COUNT(l.id) AS nbEmprunts")
                        ->orderBy("nbEmprunts", "DESC")
                        ->addOrderBy("l.titre", "ASC")
        ;
        if($max) $requete->setMaxResults($max);
        return  $requete->getQuery()
                        ->getResult()
        ;
    }





    
    // /**
    //  * @return Livre[] Returns an array of Livre objects
    //  */
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
    public function findOneBySomeField($value): ?Livre
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
