<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="shopping")
     */
    public function bag_shoping(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repoP = $em->getRepository(Produit::class);
    
        $session = new Session();

        $productsArray = [];
        $cart = [];
        $totalSum = 0;

        $session = new Session();

        if($session->get('my_cart') == null){
            $session->set('my_cart', $cart);
        }else{
            $cart = $session->get('my_cart');
        }
        
        if ($request->isMethod('post')) {
            $productQuantity = $request->request->get('qte');
            $productId = $request->request->get('product_id');

            $item[$productId] = (int)$productQuantity;

            if(array_key_exists($productId, $cart)){
                $cart[$productId] += $productQuantity;
            }else{
                $cart += $item;
            }
            $session->set('my_cart', $cart);   
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

        $repoC = $em->getRepository(Categorie::class);
        $categoriesMenu = $repoC->getCategories();

        //$session->invalidate();

        return $this->render('shopping/bag-shoping.html.twig', [
            'categoriesMenu' => $categoriesMenu,
            'cartDetails' => $cartDetails
        ]);

    }
}
