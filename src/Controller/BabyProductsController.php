<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Fourniseur;
use Symfony\Component\BrowserKit\Request;

class BabyProductsController extends AbstractController
{
    /**
     * @Route("/babyProducts", name="baby_products")
     */
    public function index()
    {
       

        return $this->render('baby_products/index.html.twig', [
            'controller_name' => 'BabyProductsController',
            
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        $em =$this->getDoctrine()->getManager();
        $repoP =$em->getRepository(Produit::class);
        $produits =$repoP->findBy( $criteria= [],  $orderBy=null ,  $limit = 10,  $offset = null);

      
        $em =$this->getDoctrine()->getManager();
        $repoF =$em->getRepository(Fourniseur::class);
        $fournisseurs =$repoF->findBy( $criteria= [],  $orderBy=null ,  $limit = 5,  $offset = null);

        
        return $this->render('baby_products/home.html.twig',[
            'produits' => $produits,
            'fournissueurs' =>$fournisseurs
        ]);
    }

    /**
     * @Route("/about-us", name="about")
     */
    public function about()
    {
        return $this->render('baby_products/about.html.twig');
    }

/**
 * @Route("/marques", name="marques")
 */
    public function marques()
    {
        $em =$this->getDoctrine()->getManager();
        $repoF =$em->getRepository(Fourniseur::class);
        $fournisseurs =$repoF->findBy( $criteria= [],  $orderBy=null ,  $limit = null,  $offset = null);

        return $this->render('baby_products/marques.html.twig',[
            'fournissueurs' =>$fournisseurs
        ]);
    }
    
    /**
     * @Route("/marques/{slug}", name="show_marque")
     */
    public function show($slug)
    {
        $em =$this->getDoctrine()->getManager();
        $repoF =$em->getRepository(Fourniseur::class);
        $fournisseur =$repoF->findOneBy(array('slug'=> $slug));
        $produits= $fournisseur->getProduits();
        dump($slug);

        return $this->render('baby_products/show.html.twig',[
            'fournisseur' =>$fournisseur
        ]);
    }
}