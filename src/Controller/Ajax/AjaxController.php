<?php

namespace App\Controller\Ajax;

use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AjaxController extends AbstractController
{
    /**
     * @Route("/cart/add/{id}/{quantity}", name="add_to_cart", methods={"POST"})
     */
    public function addAction(Request $request, $id, $quantity)
    {

        $em = $this->getDoctrine()->getManager();
        $repoP = $em->getRepository(Produit::class);
        $session = new Session();

        // $productsArray = [];
        $cart = [];
        $totalSum = 0;

        $checkProduct = $repoP->ifProductExist($id);
        if ($checkProduct) {
            if ($session->get('my_cart') == null) {
                $session->set('my_cart', $cart);
            } else {
                $cart = $session->get('my_cart');
            }
            if ($request->isMethod('post')) {
                $productQuantity = $quantity;
                $productId = $id;

                $item[$productId] = (int)$productQuantity;

                if (array_key_exists($productId, $cart)) {
                    $cart[$productId] += $productQuantity;
                } else {
                    $cart += $item;
                }
                $session->set('my_cart', $cart);
                $totalSum = $session->getPrixTotal();
            }


            return $this->json('Succeed');
        } else {
            return $this->json('Error');
        }
    }
}
