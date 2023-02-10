<?php

namespace App\Repository;

use App\Entity\Genre;
use App\Entity\Livre;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Genre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Genre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Genre[]    findAll()
 * @method Genre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenreRepository extends Depot
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Genre::class);
    }

    /*
     ? Pour faire une jointure DQL sur une relation n-n, dans la méthode 'join', il faut utiliser la propriété
     ? liée à l'entité jointe. Ne pas utiliser WITH...
    */
    public function findNbLivresMaxMin($max = true)//: int
    {
        $temp = $this->createQueryBuilder('g')
                        ->leftJoin("g.livres", "l")
                        ->select("g.libelle, COUNT(l.id) as nb")  // ? pour compter le nb de livres, il faut bien choisir le champ dans COUNT
                        ->groupBy("g.id")
                        ->orderBy("nb", $max ? "DESC" : "ASC")
                        ->setMaxResults(1)
                        ->getQuery()
                        ->getOneOrNullResult()
                        // ->getResult()
        ;
        // return $temp;
        return $temp["nb"];
    }

    public function findByNbLivres($max = true)
    {
        $temp = $this->createQueryBuilder('g')
            ->leftjoin("g.livres", "l")
            ->select("g", "COUNT(l.id) as nb")
            ->groupBy("g.id")
            ->having("nb =" . $this->findNbLivresMaxMin($max))
            ->getQuery()
            ->getResult()
        ;
        return $temp;
    }

    // /**
    //  * @return Genre[] Returns an array of Genre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Genre
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
