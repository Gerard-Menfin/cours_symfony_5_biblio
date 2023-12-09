<?php

namespace App\Repository;

use App\Entity\Abonne;
use App\Entity\Emprunt;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * @method Abonne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Abonne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Abonne[]    findAll()
 * @method Abonne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbonneRepository extends Depot implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Abonne::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof Abonne) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }
    
    /**
     Abonnés qui ont des livres non rendus
     SELECT a.*
     FROM abonne a JOIN emprunt e ON a.id = e.abonne_id
     WHERE e.dateRetour IS NULL
         NB : la jointure peut être définiée à partir des entités
     */
    public function findByLivresNonRendus(){
        $requete = $this->createQueryBuilder("a")
                        ->join(Emprunt::class, "e", "WITH", "a = e.abonne")
                        ->where("e.dateRetour IS NULL");

        return $requete->getQuery()->getResult();
    }


    /**
     *? Abonnés ordonnés par le nombre d'emprunts
     * 
     *? SELECT a.* AS abonne, COUNT(*) AS nb_emprunts
     *? FROM abonne a JOIN emprunt e ON a.id = e.abonne_id
     *? GROUP BY a.id
     *? ORDER BY nb_emprunts DESC, a.pseudo
     * 
     *? NB : donner un alias à a.* permet de le récupérer comme indice du tableau de résultat
     */
    public function findOrderedByNbEmprunts()
    {
        $requete = $this->createQueryBuilder("a")
                        ->select("a AS abonne, COUNT(a) AS nb_emprunts")
                        ->join(Emprunt::class, "e", "WITH", "a = e.abonne")
                        ->groupBy("a.id")
                        ->orderBy("nb_emprunts", "DESC")->addOrderBy("a.pseudo");
        return $requete->getQuery()->getResult();
    }

    /**
     *? Abonnés ordonnés par le nombre de livres différents empruntés
     * 
     *? SELECT a.*, COUNT(DISTINCT e.livre_id) AS nb_livres_empruntes
     *? FROM abonne a JOIN emprunt e ON a.id = e.abonne_id
     *? GROUP BY a.id 
     *? ORDER BY nb_livres_empruntes DESC, a.pseudo
     * 
     */
    public function findOrderedByNbLivresEmpruntes()
    {
        $requete = $this->createQueryBuilder("a")
                        ->select("a AS abonne, COUNT(DISTINCT e.livre) AS nb_livres_empruntes")
                        ->join(Emprunt::class, "e", "WITH", "a = e.abonne")
                        ->groupBy("a.id")
                        ->orderBy("nb_livres_empruntes", "DESC")->addOrderBy("a.pseudo");
        return $requete->getQuery()->getResult();
    }










    
    // /**
    //  * @return Abonne[] Returns an array of Abonne objects
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
    public function findOneBySomeField($value): ?Abonne
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
