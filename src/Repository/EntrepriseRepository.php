<?php

namespace App\Repository;

use App\Entity\ENTREPRISE;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ENTREPRISE|null find($id, $lockMode = null, $lockVersion = null)
 * @method ENTREPRISE|null findOneBy(array $criteria, array $orderBy = null)
 * @method ENTREPRISE[]    findAll()
 * @method ENTREPRISE[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrepriseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ENTREPRISE::class);
    }

    public function findByDepartment($departement) {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->join('App\Entity\Ville', 'v')
            ->andWhere('v.numDepartement = :dep')
            ->setParameter('dep', $departement)
            ->getQuery()
            ->getResult()
        ;
    }



    // /**
    //  * @return ENTREPRISE[] Returns an array of ENTREPRISE objects
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
    public function findOneBySomeField($value): ?ENTREPRISE
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
