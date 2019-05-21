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

        $cart = [];
        $totalSum = 0;
        $productsArray = [];

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

            $data = array(
                'status' => 'ok',
                'totalsum' => $totalSum
            );
            return  new JsonResponse($data);
        } else {
            return $this->json('Error');
        }
    }
}
