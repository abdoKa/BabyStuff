<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Produit;
use App\Entity\Categorie;
use App\Entity\Fourniseur;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Entity\Utilisateur;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    protected $faker;

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder =$encoder;
    }
    
    
    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();
 

        $slugify = new Slugify();

        $categories = array();
        $fournisseurs = array();


       
       

        for($i =1; $i <=20; $i++){
            $categorie=new Categorie();
            $categorie->setNom('Categorie ' . $i);
            $categorie->setDescription('Lorem, ipsum dolor sit amet consectetur adipisicing elit. Delectus consectetur, laudantium maxime eaque a repellendus?');
            $categorie->setImage('accessories-adorable-baby-325867.jpg');
            $slug = $slugify->slugify($categorie->getNom());
            $categorie->setSlug($slug);
            $categorie->setDateAjout($this->faker->dateTimeBetween('-10 days', 'now'));
            $categorie->setDateModif($this->faker->dateTimeBetween('-10 days', 'now'));



            $fournisseur = new Fourniseur();
            $fournisseur->setNom('Fourniseur ' .$i);
            $fournisseur->setDescription('Lorem, ipsum dolor sit amet consectetur adipisicing elit. Delectus consectetur, laudantium maxime eaque a repellendus?');
            $fournisseur->setImage('HM-Share-Image.jpg');
            $slug = $slugify->slugify($fournisseur->getNom());
            $fournisseur->setSlug($slug);
            $fournisseur->setDateAjout($this->faker->dateTimeBetween('-10 days', 'now'));
            $fournisseur->setDateModif($this->faker->dateTimeBetween('-10 days', 'now'));
            
            $manager->persist($categorie);
            $manager->persist($fournisseur);

            array_push($fournisseurs, $fournisseur);
            array_push($categories, $categorie);
            
            
        }
        
        for($i =1; $i <=500; $i++){
        
            $produit = new Produit();
            $produit->setReferance('Ref' .$i);
            $produit->setNom('Produit ' .$i);
            $produit->setImage('accessories-adorable-baby-325867.jpg');
            $produit->setDescription('Lorem, ipsum dolor sit amet consectetur adipisicing elit');
            $produit->setPrix('50');
            $produit->setStock(50);
            $produit->setFeatures((bool)\rand(0,1));
            $produit->setFourniseur($fournisseurs[mt_rand(0,19)]);
            $produit->setCategorie($categories[mt_rand(0,19)]);
          

            $manager->persist($produit);
        }


        $user = new Utilisateur();
        $user->setNom('Abdelali');
        $user->setPrenom('Kabou');
        $user->setAdresse('str Abdelah senahjy 169');
        $user->setEmail('abdellalikabou39@gmail.com');
        $user->setTelephone(605267483);
        $user->setPassword(
            $this->encoder->encodePassword($user, 'ali649'));
        $user->setRoles('ROLE_ADMIN');

        $manager->persist($user);

        $manager->flush();
    }
}