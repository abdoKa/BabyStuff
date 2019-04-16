<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Fourniseur;
use App\Entity\Categorie;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class BabyProductsController extends AbstractController
{


    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        $em =$this->getDoctrine()->getManager();
        $repoP =$em->getRepository(Produit::class);
        $produits =$repoP->getLastProducts();


        $repoF =$em->getRepository(Fourniseur::class);
        $fournisseurs =$repoF->getMarques();    

        $repoFea =$em->getRepository(Produit::class);
        $features =$repoFea->getFeatures();



        $repoC =$em->getRepository(Categorie::class);
        $categoriesMenu =$repoC->getCategories();

        return $this->render('baby_products/home.html.twig',[
            'produits' => $produits,
            'fournissueurs' =>$fournisseurs,
            'features' => $features,
            'categoriesMenu' =>$categoriesMenu
            ]);

    }

    /**
     * @Route("/a-propos", name="about")
     */
    public function about()
    {
        $em =$this->getDoctrine()->getManager();

        $repoC =$em->getRepository(Categorie::class);
        $categoriesMenu =$repoC->getCategories();

        return $this->render('baby_products/about.html.twig' ,[
            'categoriesMenu' =>$categoriesMenu

        ]);
    }

/**
 * @Route("/marques", name="marques")
 */
    public function marques(PaginatorInterface $paginator,Request $request):Response
    {
        $em =$this->getDoctrine()->getManager();
        $repoF =$em->getRepository(Fourniseur::class);

<<<<<<< HEAD
        $pagination = $paginator->paginate(
            $repoF->getAllmarquesQuery(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/
=======
        $repoC =$em->getRepository(Categorie::class);
        $categoriesMenu =$repoC->getCategories();

        $pagination =$paginator->paginate(
            $repoF->getAllmarquesQuery(),
            $request->query->getInt('page', 1) ,12
>>>>>>> f256c5e09347d568c0d5f7d03a83800ab960fe2f
        );

       

        return $this->render('baby_products/marques.html.twig',[
<<<<<<< HEAD
            'pagination' => $pagination,
            
=======
            'pagination' =>$pagination,
            'categoriesMenu' =>$categoriesMenu

>>>>>>> f256c5e09347d568c0d5f7d03a83800ab960fe2f
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

        $repoC =$em->getRepository(Categorie::class);
        $categoriesMenu =$repoC->getCategories();

        return $this->render('baby_products/show-marques.html.twig',[
            'fournisseur' =>$fournisseur,
            'produits' => $produits,
            'categoriesMenu' =>$categoriesMenu

        ]);
    }

    

     /**
     * @Route("/categorie/{slug}", name="show_categorie")
     */
    public function show_cat($slug,PaginatorInterface $paginator,Request $request)
    {
        $em =$this->getDoctrine()->getManager();

        $repoC =$em->getRepository(Categorie::class);
        $categorie =$repoC->findOneBy(array('slug'=> $slug));
       

        $categoriesMenu =$repoC->getCategories();
        $produits= $categorie->getProduits();

        $pagination =$paginator->paginate(
            $produits,
            $request->query->getInt('page', 1) ,12
        );
        dump($produits);
        return $this->render('baby_products/show-cat.html.twig',[
            'categorie' =>$categorie,  
            'categoriesMenu' =>$categoriesMenu,
            'produits'=>$produits, 
            'pagination' =>$pagination,



        ]);
    }
    /**
     * @Route("/produit/{slug}", name="single_product")
     */
    public function show_product($slug)
    {
        
        $em =$this->getDoctrine()->getManager();
        $repoF =$em->getRepository(Produit::class);
        $single_p =$repoF->findOneBy(array('slug'=> $slug));

        
        
        $repoC =$em->getRepository(Categorie::class);
        $categoriesMenu =$repoC->getCategories();
        
        return $this->render('baby_products/show-product.html.twig',[
            'single_p' =>$single_p,
            'categoriesMenu' =>$categoriesMenu
        ]);
    }
}