<?php

namespace App\Repository;

use App\Entity\Livre;
use App\Entity\Entity;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/*
    Toutes les classes Repository devront hériter de cette classe Depot
    pour avoir des méthodes génériques
    C'est une classe abstraite parce qu'on ne doit pas instancier d'objet de cette classe 
*/
abstract class Depot extends ServiceEntityRepository
{
    /**
     * Renvoie le nombre d'enregistrement de la table
     * @return int
     */
    public function nb() : int
    {
        $resultat = $this->createQueryBuilder('a')
                        ->select("COUNT(a.id) as nb")
                        ->getQuery()
                        ->getOneOrNullResult()
                    ;
        return $resultat ? $resultat["nb"] : 0;
    }

    /**
     * La méthode findAll de la classe Doctrine\ORM\EntityRepository appelle $this->findBy([])
     * et donc ne peut pas être triée. On la redéfinie (= surcharge) dans la classe dont tous 
     * les Repositories vont hériter : 
     *
     * @param array|null $orderBy
     * 
     * @return array d'entités.
     */
    public function findAll($orderBy = null)
    {
        return $this->findBy([], $orderBy);
    }

    /**
     * Le nom de la BDD actuellement utilisée
     */
    public function nomBDD(){
        return $this->getEntityManager()->getConnection()->getDatabase();
    }

    // Depuis la version 6... ?
    public function save(Entity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Entity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function record(Entity $entite)
    {
        $this->save($entite, true);
    }

    public function del(Entity $entite)
    {
        $this->remove($entite, true);
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
