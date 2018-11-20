<?php

namespace App\Repository;

use App\Entity\Phweep;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Phweep|null find($id, $lockMode = null, $lockVersion = null)
 * @method Phweep|null findOneBy(array $criteria, array $orderBy = null)
 * @method Phweep[]    findAll()
 * @method Phweep[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhweepRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Phweep::class);
    }

    // /**
    //  * @return Phweep[] Returns an array of Phweep objects
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
    public function findOneBySomeField($value): ?Phweep
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
