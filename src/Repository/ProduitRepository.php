<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Produit::class);
    }


    public function getLastProducts(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        SELECT * FROM produit 
        ORDER By date_modif
        DESC
        LIMIT 10
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getFeatures(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        SELECT * FROM produit
        WHERE features =1
        LIMIT 10
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getAllB_Features(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        SELECT * FROM produit WHERE features =1
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function getFournisseurById($id)
    {
        $conn = $this->getEntityManager()->getConnection();
        $statement = $conn->prepare("SELECT * FROM fourniseur WHERE id = :id");
        $statement->bindValue('id', $id);
        $statement->execute();
        return $statement->fetchAll();
    }
    
    // backend categories
    
    public  function getCategoriesTable()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        SELECT produit.nom ,categorie.nom ,fourniseur.nom,produit.prix, produit.image,produit.stock 
        FROM produit,categorie,fourniseur 
        where categorie.id=categorie_id and 
        fourniseur.id=fourniseur_id
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function ifProductExist($id)
    {
        $sql = "
            SELECT 
            c FROM 
            App:Produit c
            WHERE
            c.id=:id  
        ";
        $result = $this->getEntityManager()->createQuery($sql)
            ->setParameter('id', $id)
            ->getOneOrNullResult();
        if (null == $result) {
            return false;
        } else {
            return true;
        }
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
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
    public function findOneBySomeField($value): ?Produit
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
