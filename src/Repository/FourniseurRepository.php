<?php

namespace App\Repository;

use App\Entity\Fourniseur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query;

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
    public function getMarques(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        SELECT * FROM fourniseur LIMIT 10
        ';
        $stmt = $conn->prepare($sql); 
        $stmt->execute();
        return $stmt->fetchAll();
    }

  
    public function getAllmarquesQuery(){
        return $this->findAll();          
    }
  

}