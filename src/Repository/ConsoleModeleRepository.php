<?php

namespace App\Repository;

use App\Entity\ConsoleModele;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ConsoleModele|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConsoleModele|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConsoleModele[]    findAll()
 * @method ConsoleModele[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsoleModeleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConsoleModele::class);
    }

    // /**
    //  * @return ConsoleModele[] Returns an array of ConsoleModele objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ConsoleModele
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
