<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Entity\Fourniseur;
use App\Entity\ProductLike;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Cookie;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\PrppertySearchType;
use App\Entity\CategorySearch;
use App\Form\CategorySearchType;
use Proxies\__CG__\App\Entity\Produit as ProxiesProduit;

class BabyProductsController extends AbstractController
{


    /**
     * @Route("/", name="home")
     */
    public function home(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $repoP = $em->getRepository(Produit::class);
       
        $produits = $repoP->getLastProducts();


        $repoF = $em->getRepository(Fourniseur::class);
        $fournisseurs = $repoF->getMarques();

        $repoFea = $em->getRepository(Produit::class);
        $features = $repoFea->getFeatures();

        return $this->render('baby_products/home.html.twig', [
            'produits' => $produits,
            'fournissueurs' => $fournisseurs,
            'features' => $features,
        ]);
    }
   

    public function menuNav()
    {
        $em = $this->getDoctrine()->getManager();

        $repoC = $em->getRepository(Categorie::class);
        $repoP = $em->getRepository(Produit::class);

        $categoriesMenu = $repoC->getCategories();

        $em = $this->getDoctrine()->getManager();
        $repoLike = $em->getRepository(ProductLike::class);
        $likes = $repoLike->find('id');

        $session = new Session();
        $productsArray = [];
        $cart = [];
        $totalSum = 0;

        if ($session->get('my_cart') == null) {
            $session->set('my_cart', $cart);
        } else {
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

        $cartDetails = ['products' => $productsArray, 'totalsum' => $totalSum];

        return $this->render(
            'menu.html.twig',
            [
                'categoriesMenu' => $categoriesMenu,
                'cartDetails' => $cartDetails,
                'likes' => $likes
            ]
        );
    }

    /**
     * @Route("/about-us", name="about")
     */
    public function about()
    {
        return $this->render('baby_products/about.html.twig', []);
    }


    /**
     * @Route("/brands", name="marques")
     */
    public function marques(PaginatorInterface $paginator, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $repoF = $em->getRepository(Fourniseur::class);



        $pagination = $paginator->paginate(
            $repoF->getAllmarquesQuery(),
            $request->query->getInt('page', 1),
            9
        );



        return $this->render('baby_products/marques.html.twig', [
            'pagination' => $pagination,


        ]);
    }

    /**
     * @Route("/brands/{slug}", name="show_marque")
     */
    public function show($slug, PaginatorInterface $paginator, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repoF = $em->getRepository(Fourniseur::class);

        $fournisseur = $repoF->findOneBy(array('slug' => $slug));
        $products = $fournisseur->getProduits();




        $pagination = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('baby_products/show-marques.html.twig', [
            'fournisseur' => $fournisseur,
            'products' => $products,
            'pagination' => $pagination

        ]);
    }


    /**
     * @Route("/all-categories", name="show-all-categories")
     * 
     */
    public function show_all_cat(PaginatorInterface $paginator, Request $request)
    {


        $em = $this->getDoctrine()->getManager();
        $repoC = $em->getRepository(Categorie::class);


        $pagination = $paginator->paginate(
            $repoC->findAll(),
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('baby_products/allcategorie.html.twig', [
            'pagination' => $pagination,
        ]);
    }


    /**
     * @Route("/categorie/{slug}", name="show_categorie")
     * @return Response
     */
    public function show_cat($slug, PaginatorInterface $paginator, Request $request)
    {


        $em = $this->getDoctrine()->getManager();
        $repoC = $em->getRepository(Categorie::class);
        $categorie = $repoC->findOneBy(array('slug' => $slug));
        $produits = $categorie->getProduits();

        $pagination = $paginator->paginate(
            $produits,
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('baby_products/show-cat.html.twig', [
            'categorie' => $categorie,
            'produits' => $produits,
            'pagination' => $pagination,




        ]);
    }

    /**
     * @Route("/product/{slug}", name="single_product")
     */
    public function show_product($slug): Response
    {

        $em = $this->getDoctrine()->getManager();
        $repoF = $em->getRepository(Produit::class);

        $single_p = $repoF->findOneBy(array('slug' => $slug));
        $fournisseur = $single_p->getFourniseur();

        return $this->render('baby_products/show-product.html.twig', [
            'single_p' => $single_p,
            'fournisseur' => $fournisseur
        ]);
    }
}
