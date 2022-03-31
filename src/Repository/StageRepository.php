<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    public function findByPromo($promo)
    {
        return $this->createQueryBuilder('s')
        ->select('s')
        ->innerJoin('App\Entity\Etudiant', 'e')
        ->where('e.promotion = :promo')
        ->setParameter('promo', $promo)
        ->getQuery()
        ->getResult()
        ;
    }
    
    public function findByPromo2($promo)
    {
        $req = 'SELECT e FROM App\Entity\Stage s JOIN App\Entity\Etudiant e';
        $query = $this->getEntityManager()->createQuery($req);
        //$query->setParameter(':promo', $promo);
        return $query->getResult();
    }
    // /**
    //  * @return Stage[] Returns an array of Stage objects
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
    public function findOneBySomeField($value): ?Stage
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
