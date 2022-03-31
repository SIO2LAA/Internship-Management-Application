<?php

namespace App\Repository;

use App\Entity\PROFESSIONNEL;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PROFESSIONNEL|null find($id, $lockMode = null, $lockVersion = null)
 * @method PROFESSIONNEL|null findOneBy(array $criteria, array $orderBy = null)
 * @method PROFESSIONNEL[]    findAll()
 * @method PROFESSIONNEL[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfessionnelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PROFESSIONNEL::class);
    }

    // /**
    //  * @return PROFESSIONNEL[] Returns an array of PROFESSIONNEL objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PROFESSIONNEL
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
