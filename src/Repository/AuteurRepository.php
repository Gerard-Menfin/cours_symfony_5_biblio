<?php

namespace App\Repository;

use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Emprunt;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface as EMI;

/**
 * @method Auteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Auteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Auteur[]    findAll()
 * @method Auteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuteurRepository extends Depot
{
    public EMI $em;
    public function __construct(ManagerRegistry $registry, EMI $em)
    {
        parent::__construct($registry, Auteur::class);
        $this->em = $em;
    }
    
    /**
     * @return Auteur[] Returns an array of Auteur objects

      SELECT a 
      FROM auteur a JOIN livre l ON a.id = l.auteur_id 
      GROUP BY a.id 
      HAVING count(*) = (SELECT max(t.nb) 
                         FROM (SELECT count(*) as nb 
                               FROM auteur a JOIN livre l ON a.id = l.auteur_id 
                               GROUP BY a.id) t)      
     */
    
    public function findProlifique($plus = true): ?Auteur
    {
        // $query = $this->em->createQuery("SELECT a 
        //                                  FROM App\Entity\Auteur a JOIN App\Entity\Livre l WITH a.id = l.auteur 
        //                                  GROUP BY a.id 
        //                                  HAVING count(a) = (SELECT max(t.nb) 
        //                                                     FROM nb_livres_par_auteur t) ");
        // return $query->getResult();
        $sousRequete = $plus ? "SELECT max(t.nb)" : "SELECT min(t.nb)";
        $sousRequete .= "FROM (SELECT count(*) as nb 
                               FROM auteur a JOIN livre l ON a.id = l.auteur_id 
                               GROUP BY a.id) t";
        $query = $this->em->getConnection()->query("SELECT a.*
                                                     FROM auteur a JOIN livre l ON a.id = l.auteur_id 
                                                     GROUP BY a.id 
                                                     HAVING count(*) = ($sousRequete)");
        $result = $query->fetchAll();
        $auteur = $result[0];
        $auteur = $this->find($auteur["id"]);
        return $auteur;
    }
   
    // /**
    //  * @return Auteur[] Returns an array of Auteur objects
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
    public function findOneBySomeField($value): ?Auteur
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
