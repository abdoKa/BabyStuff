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

class AppFixtures extends Fixture
{
    protected $faker;


    
    
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
            $categorie->setImage('http://placehold.it/480x270');
            $slug = $slugify->slugify($categorie->getNom());
            $categorie->setSlug($slug);
            $categorie->setDateAjout($this->faker->dateTimeBetween('-10 days', 'now'));
            $categorie->setDateModif($this->faker->dateTimeBetween('-10 days', 'now'));



            $fournisseur = new Fourniseur();
            $fournisseur->setNom('Fourniseur ' .$i);
            $fournisseur->setDescription('Lorem, ipsum dolor sit amet consectetur adipisicing elit. Delectus consectetur, laudantium maxime eaque a repellendus?');
            $fournisseur->setImage('http://placehold.it/400x200');
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
            $produit->setImage('http://placehold.it/400x150');
            $produit->setDescription('Lorem, ipsum dolor sit amet consectetur adipisicing elit');
            $produit->setPrix('50');
            $produit->setStock(50);
            $produit->setFeatures((bool)\rand(0,1));
            $slug = $slugify->slugify($produit->getNom());
            $produit->setSlug($slug);
            $produit->setFourniseur($fournisseurs[mt_rand(0,19)]);
            $produit->setCategorie($categories[mt_rand(0,19)]);
            $produit->setDateAjout($this->faker->dateTimeBetween('-10 days', 'now'));
            $produit->setDateModif($this->faker->dateTimeBetween('-10 days', 'now'));

            $manager->persist($produit);
        }

        $manager->flush();
    }
}