<?php

namespace App\Repository;

use App\Entity\Ville;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ville|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ville|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ville[]    findAll()
 * @method Ville[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VilleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ville::class);
    }

    public function findAllDepartments() {
        return $this->createQueryBuilder('v')
            ->select('v.numDepartement')
            ->orderBy('v.numDepartement', 'ASC')
            ->groupBy('v.numDepartement')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Ville[] Returns an array of Ville objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ville
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    public function joinVille($idVille, $idEtudiant)
    {
        return $this->createQueryBuilder('v')
        ->update('Etudiant', 'e')->set('e.ville_id', ':idVille')
        ->where('e.id = :idEtudiant')
        ->setParameter('idVille', $idVille)
        ->setParameter('idEtudiant', $idEtudiant);
    }
}
