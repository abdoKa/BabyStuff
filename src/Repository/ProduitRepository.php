<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Request;
use EasyCorp\Bundle\EasyAdminBundle\Search\QueryBuilder;
use Doctrine\ORM\QueryBuilder as DoctrineQueryBuilder;

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
    /**
     * Undocumented function
     *
     * @param string|null $term
     */
    public function getWithSearch(?string $term): DoctrineQueryBuilder
    {
        $qb = $this->createQueryBuilder('c');

        if ($term) {
            $qb->andWhere('c.nom LIKE :term OR c.referance LIKE :term')
                ->setParameter('term', '%' . $term . '%');
        }

        return $qb
            ->orderBy('c.dateAjout', 'DESC');
           
    }

    // public function findAllProducts()
    // {
    //     return $this->_em->createQuery(
    //         "
    //             SELECT bp 
    //             FROM App:Produit bp
    //         "
    //     );
    //     return $this->_em->getRepository(Produit::class)->createQueryBuilder('bp');
    // }
    // public function getAction(Request $request)
    // {
    //     return $this->_em->getRepository(Produit::class)->findAllProducts()->getQuery()->getResult();

    //     $queryBuilder = $this->_em->getRepository(Produit::class)->findAllProducts();
    //     if ($request->query->getAlnum('filter')) {

    //         $queryBuilder
    //             ->where('bp.nom LIKE :nom')
    //             ->setParameter('nom', '%' . $request->query->getAlnum('filter') . '%');
    //     }

    //     return $this->get('knp_paginator')->paginate(
    //         $queryBuilder->getQuery(),
    //         $request->query->getInt('page',1),
    //         $request->query->getInt('limit',1)
    //     );
    // }
}
