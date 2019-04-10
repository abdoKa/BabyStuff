<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Categorie;

class AppFixtures extends Fixture
{
    private $slugify;
    public function __construct(\Cocur\Slugify\SlugifyInterface $slugify)
    {
        $this->slugify = $slugify;
    } 

    public function load(ObjectManager $manager)
    {
        
        for($i =0; $i <=30; $i++){
            $categorie=new Categorie();
            $categorie->setNom('Categorie ' .$i);
            $categorie->setDescription('Lorem, ipsum dolor sit amet consectetur adipisicing elit. Delectus consectetur, laudantium maxime eaque a repellendus?');
            $categorie->setImage('http://palcehold.it/400x200');
            $slug = $slugify->slugify('Categorie ' .$i);
            $categorie->setSlug($slug);

            $manager->persist($categorie);
        }

        $manager->flush();
    }
}
