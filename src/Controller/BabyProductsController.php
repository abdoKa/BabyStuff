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

        // $repoF =$em->getRepository(Categorie::class);
        // $categories =$repoF->findBy( $criteria= [],  $orderBy=null ,  $limit =10,  $offset = null);

        return $this->render('baby_products/home.html.twig',[
            'produits' => $produits,
            'fournissueurs' =>$fournisseurs,
            'features' => $features,
            // 'categories' =>$categories
            ]);



    }

    /**
     * @Route("/a-propos", name="about")
     */
    public function about()
    {
        return $this->render('baby_products/about.html.twig');
    }

/**
 * @Route("/marques", name="marques")
 */
    public function marques(PaginatorInterface $paginator, Request $request)
    {
        $em =$this->getDoctrine()->getManager();
        $repoF =$em->getRepository(Fourniseur::class);

        $pagination = $paginator->paginate(
            $repoF->getAllmarquesQuery(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/
        );

       

        return $this->render('baby_products/marques.html.twig',[
            'pagination' => $pagination,
            
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


        return $this->render('baby_products/show.html.twig',[
            'fournisseur' =>$fournisseur,
            'produits' => $produits
        ]);
    }


}