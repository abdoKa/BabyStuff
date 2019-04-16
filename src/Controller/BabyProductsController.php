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

        $repoC =$em->getRepository(Categorie::class);
        $categoriesMenu =$repoC->getCategories();

        $pagination =$paginator->paginate(
            $repoF->getAllmarquesQuery(),
            $request->query->getInt('page', 1) ,12
        );

        return $this->render('baby_products/marques.html.twig',[
            'pagination' =>$pagination,
            'categoriesMenu' =>$categoriesMenu

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

        return $this->render('baby_products/show.html.twig',[
            'fournisseur' =>$fournisseur,
            'produits' => $produits,
            'categoriesMenu' =>$categoriesMenu

        ]);
    }

    /**
     * @Route("/categorie", name="categorie")
     */
    public function categorie(PaginatorInterface $paginator,Request $request):Response
    {
        $em =$this->getDoctrine()->getManager();

        $repoC =$em->getRepository(Categorie::class);
        $categoriesMenu =$repoC->getCategories();

        $pagination =$paginator->paginate(
            $repoC->findAll(),
            $request->query->getInt('page', 1) ,12
        );

        return $this->render('baby_products/categorie.html.twig',[
            'pagination' =>$pagination,
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
            $repoC->findAll(),
            $request->query->getInt('page', 1) ,6
        );
        return $this->render('baby_products/show-cat.html.twig',[
            'categorie' =>$categorie,  
            'categoriesMenu' =>$categoriesMenu,
            'produits'=>$produits, 
            'pagination' =>$pagination,



        ]);
    }

}