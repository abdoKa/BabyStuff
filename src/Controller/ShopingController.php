<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;
use App\Entity\Produit;

class ShopingController extends AbstractController
{
    /**
     * @Route("/panier", name="shoping")
     */
    public function bag_shoping()
    {
        $em =$this->getDoctrine()->getManager();
        $repoC =$em->getRepository(Categorie::class);
        $categoriesMenu =$repoC->getCategories();

        
 


        // $productRepository = $em->getRepository(Produit::class);
        // $productsArray = [];
        // $cart = [];
        // $totalSum = 0;

        return $this->render('shoping/bag-shoping.html.twig', [
            'categoriesMenu' =>$categoriesMenu
            // 'productsArray'=>$productsArray

           
        ]);
    }
}