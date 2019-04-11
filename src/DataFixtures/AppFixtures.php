<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Categorie;
use App\Entity\Fourniseur;
use App\Entity\Produit;
use Cocur\Slugify\Slugify;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $slugify = new Slugify();

        $categories = array();
        $fournisseurs = array();

        for($i =1; $i <=30; $i++){
            $categorie=new Categorie();
            $categorie->setNom('Categorie ' . $i);
            $categorie->setDescription('Lorem, ipsum dolor sit amet consectetur adipisicing elit. Delectus consectetur, laudantium maxime eaque a repellendus?');
            $categorie->setImage('http://palcehold.it/400x200');
            $slug = $slugify->slugify($categorie->getNom());
            $categorie->setSlug($slug);
            
            $fournisseur = new Fourniseur();
            $fournisseur->setNom('Fourniseur ' .$i);
            $fournisseur->setDescription('Lorem, ipsum dolor sit amet consectetur adipisicing elit. Delectus consectetur, laudantium maxime eaque a repellendus?');
            $fournisseur->setImage('http://placehold.it/400x200');
            $slug = $slugify->slugify($fournisseur->getNom());
            $fournisseur->setSlug($slug);
            
            $manager->persist($categorie);
            $manager->persist($fournisseur);

            array_push($fournisseurs, $fournisseur);
            array_push($categories, $categorie);
            
            
        }
        for($i =1; $i <=30; $i++){
        
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
            $produit->setFourniseur($fournisseurs[mt_rand(0,29)]);
            $produit->setCategorie($categories[mt_rand(0,29)]);

            $manager->persist($produit);
        }

        $manager->flush();
    }
}
