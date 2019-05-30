<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\CategorySearch;

/**
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    // /**
    //  * @return Categorie[] Returns an array of Categorie objects
    //  */


    public function getCategories(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        SELECT * FROM categorie LIMIT 10
        ';
        $stmt = $conn->prepare($sql); 
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function getAllCategories(CategorySearch $search): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT * FROM categorie ';
        $stmt = $conn->prepare($sql); 
        $stmt->execute();
        return $stmt->fetchAll();
    }

   
   

}
