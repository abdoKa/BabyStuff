<?php

namespace App\Repository;

use App\Entity\Fourniseur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Fourniseur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fourniseur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fourniseur[]    findAll()
 * @method Fourniseur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FourniseurRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Fourniseur::class);
    }

    // /**
    //  * @return Fourniseur[] Returns an array of Fourniseur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fourniseur
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
