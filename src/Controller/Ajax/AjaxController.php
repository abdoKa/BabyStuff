<?php

namespace App\Controller\Ajax;

use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AjaxController extends AbstractController
{
    /**
     * @Route("/cart/add", name="add_to_cart", methods={"GET","POST"})
     */
    public function addAction(Request $request)
    {
        $session = $request->getSession();
        $cart = [];

        $em = $this->getDoctrine()->getManager();
        $repoP = $em->getRepository(Produit::class);


        $productId = $request->request->getInt('id');
        $product = $repoP->find($productId);

        $user = $this->getUser();

        // if (!is_object($product)) {
        //     return $this->returnErrorJson('product not found');
        // } elseif (!is_object($user)) {
        //     return $this->returnErrorJson('must be registered');
        // }   

        if ($session->get('my_cart') == null) {
            $session->set('my_cart', $cart);
        } else {
            $cart = $session->get('my_cart');
        }
        $sum = 0;
        foreach ($cart as $productId => $productQuantity) {
            $product = $repoP->find((int)$productId);
            if (is_object($product)) {
                $quantity = abs((int)$productQuantity);
                $sum += ($quantity * $product->getPrix());
            }
        }
        $cartDetails = ['products' => $product, 'totalsum' => $sum];

        
        $cartDetails = false;
        return new JsonResponse([
            'add to cart ' => $cartDetails,
            'success' => true
        ], 200);
        dump($cartDetails);
        die();  
    }
}
