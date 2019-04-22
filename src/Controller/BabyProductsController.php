<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Fourniseur;
use App\Entity\Categorie;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

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



        

        return $this->render('baby_products/home.html.twig',[
            'produits' => $produits,
            'fournissueurs' =>$fournisseurs,
            'features' => $features,
            ]);

    }

    public function menuNav()
    {
        $em =$this->getDoctrine()->getManager();

        $repoC =$em->getRepository(Categorie::class);
        $repoP = $em->getRepository(Produit::class);

        $categoriesMenu =$repoC->getCategories();

        $session = new Session();
        $productsArray = [];
        $cart = [];
        $totalSum = 0;

        if($session->get('my_cart') == null){
            $session->set('my_cart', $cart);
        }else{
            $cart = $session->get('my_cart');

        }

            foreach ($cart as $productId => $productQuantity) {
                $product = $repoP->findOneBy([
                    'id' => $productId,
                ]);
    
                if (is_object($product)) {
                    $productPosition = [];
                    $quantity = abs((int)$productQuantity);
                    $price = $product->getPrix();
                    $sum = $price * $quantity;
                    $productPosition['product'] = $product;
                    $productPosition['quantity'] = $quantity;
                    $productPosition['price'] = $price;
                    $productPosition['sum'] = $sum;
                    $totalSum += $sum;
                    $productsArray[] = $productPosition;
                }
            }

        $cartDetails = ['products' => $productsArray, 'totalsum' => $totalSum ];

      
        return $this->render(
            'menu.html.twig',['categoriesMenu' =>$categoriesMenu,
             'cartDetails' => $cartDetails]
        );
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

        

        $pagination =$paginator->paginate(
            $repoF->getAllmarquesQuery(),
            $request->query->getInt('page', 1) ,9
        );

       

        return $this->render('baby_products/marques.html.twig',[
            'pagination' =>$pagination,
            

        ]);
    }

    /**
     * @Route("/marques/{slug}", name="show_marque")
     */
    public function show($slug, PaginatorInterface $paginator, Request $request)
    {
        $em =$this->getDoctrine()->getManager();
        $repoF =$em->getRepository(Fourniseur::class);
        $fournisseur =$repoF->findOneBy(array('slug'=> $slug));
        $produits= $fournisseur->getProduits();

        
        
        
        $pagination =$paginator->paginate(
            $repoF->getAllmarquesQuery(),
            $request->query->getInt('page',1),9
        );

        dump($pagination);
        return $this->render('baby_products/show-marques.html.twig',[
            'fournisseur' =>$fournisseur,
            'produits' => $produits,
            'pagination' =>$pagination

        ]);
    }

    
     /**
     * @Route("/tous-categorie", name="show-all-categories")
     */
    public function show_all_cat(PaginatorInterface $paginator,Request $request)
    {
        $em =$this->getDoctrine()->getManager();
        $repoC =$em->getRepository(Categorie::class);
        $categoriesMenu =$repoC->getCategories();


        $pagination =$paginator->paginate(
            $repoC->getAllCategories(),
            $request->query->getInt('page', 1) ,9
        );
            dump($repoC);

        return $this->render('baby_products/allcategorie.html.twig',[
            'categoriesMenu' =>$categoriesMenu,
            'pagination' =>$pagination,
        ]);
    }


     /**
     * @Route("/categorie/{slug}", name="show_categorie")
     */
    public function show_cat($slug,PaginatorInterface $paginator,Request $request)
    {
        $em =$this->getDoctrine()->getManager();
        $repoC =$em->getRepository(Categorie::class);
        $categoriesMenu =$repoC->getCategories();
        $categorie =$repoC->findOneBy(array('slug'=> $slug));
        $produits= $categorie->getProduits();

        $pagination =$paginator->paginate(
            $produits,
            $request->query->getInt('page', 1) ,9
        );
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
        $fournisseur=$single_p->getFourniseur();

        $repoC =$em->getRepository(Categorie::class);
        $categoriesMenu =$repoC->getCategories();
        return $this->render('baby_products/show-product.html.twig',[
            'single_p' =>$single_p,
            'categoriesMenu' =>$categoriesMenu,
            'fournisseur'=>$fournisseur
        ]);
    }
}