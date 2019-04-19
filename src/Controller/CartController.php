<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ShopingController extends AbstractController
{
    /**
     * @Route("/panier", name="shopping")
     */
    public function bag_shoping(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repoP = $em->getRepository(Produit::class);
    
        $session = new Session();
<<<<<<< HEAD
        
        // $session->invalidate();
        $cart = array();
        $cart['listproducts'] = array();
        $cart['total'] = 0;
        
        if ($session->get('my_cart') == null) {
=======

        $productsArray = [];
        $cart = [];
        $totalSum = 0;

        $session = new Session();

        if($session->get('my_cart') == null){
>>>>>>> 1742a53ce97bddb2bfc6427d33d4cf2ebdebc33c
            $session->set('my_cart', $cart);
        }else{
            $cart = $session->get('my_cart');
        }
        
        if ($request->isMethod('post')) {
<<<<<<< HEAD
            
            $quantity = $request->request->get('qte');
            $product_id = $request->request->get('product_id');
            
            $repository = $this->getDoctrine()->getRepository(Produit::class);
            $product0 = $repository->findOneBy([
                'id' => $product_id,
            ]);

            $prix = $product0->getPrix();
            $total_product = $prix * $quantity;

            $product = array($product0, 'qte' => $quantity, 'total' => $total_product);
                

            array_push($cart['listproducts'], $product);

            foreach ($cart['listproducts'] as $product) {
                $cart['total'] += $product['total'];
            }
            $cart = array(
                'listproducts' => $cart['listproducts'],
                'total' => $cart['total'],
            );
            $session->set('my_cart', $cart);

=======
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
>>>>>>> 1742a53ce97bddb2bfc6427d33d4cf2ebdebc33c
        }

        $cartDetails = ['products' => $productsArray, 'totalsum' => $totalSum ];

        $repoC = $em->getRepository(Categorie::class);
        $categoriesMenu = $repoC->getCategories();

<<<<<<< HEAD
       


        return $this->render('shopping/bag-shoping.html.twig', [
            'categoriesMenu' => $categoriesMenu,
            'product0'=>$product0
=======
        //$session->invalidate();

        return $this->render('shopping/bag-shoping.html.twig', [
            'categoriesMenu' => $categoriesMenu,
            'cartDetails' => $cartDetails
>>>>>>> 1742a53ce97bddb2bfc6427d33d4cf2ebdebc33c
        ]);

    }
}
