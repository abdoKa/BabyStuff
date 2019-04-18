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
        $session = new Session();
        
        // $session->invalidate();
        $cart = array();
        $cart['listproducts'] = array();
        $cart['total'] = 0;
        
        if ($session->get('my_cart') == null) {
            $session->set('my_cart', $cart);
        } else {
            $cart = $session->get('my_cart');
        }
        
        if ($request->isMethod('post')) {
            
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

        }

        $em = $this->getDoctrine()->getManager();
        $repoC = $em->getRepository(Categorie::class);
        $categoriesMenu = $repoC->getCategories();


        return $this->render('shopping/bag-shoping.html.twig', [
            'categoriesMenu' => $categoriesMenu,
        ]);

    }
}
