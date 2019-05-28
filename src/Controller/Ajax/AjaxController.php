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
                    // die();
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
    /**
     * @Route("/cart/remove/{id}", name="remove_one_product", methods={"POST"})
     */

    public function removeAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repoP = $em->getRepository(Produit::class);
        $checkProduct = $repoP->ifProductExist($id);
        $session = new Session();

        $cart = [];
        $totalSum = 0;
        $productsArray = [];





        if ($checkProduct) {
            if ($session->get('my_cart') == null) {
                $session->set('my_cart', $cart);
            } else {
                $cart = $session->get('my_cart');
            }


            if ($request->isMethod('post')) {
                unset($cart[$id]);
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
                'cart' => count($cart),
                'totalSum' => $totalSum

            );

            return  new JsonResponse($data);
        } else {
            $data = array(
                'status' => 'error',
            );
        }
    }

    /**
     * @Route("cart/remove/all/products", name="remove_all_products", methods={"POST"})
     */

    public function removeAllAction()
    {
        $cart = [];
        $session = new Session();

        if ($session->get('my_cart') == null) {
            $session->set('my_cart', $cart);
        } else {
            $cart = $session->get('my_cart');
        }

        $data = array(
            'status' => 'ok',
            'removeSession' => $session->remove('my_cart')
        );
        return  new JsonResponse($data);
    }

    /**
     * @Route("cart/edit/quantity/{id}/{quantity}", name="edit_quantity_in_cart", methods={"POST"})
     */

    public function editQuantity(Request $request, $id, $quantity)
    {
        $em = $this->getDoctrine()->getManager();
        $repoP = $em->getRepository(Produit::class);

        $session = new Session();

        $cart = [];
        $totalSum = 0;
        $productsArray = [];
        $singleProductQte = (int)$quantity;

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
                    $cart[$productId] = $productQuantity;
                } else {
                    $cart += $item;
                }
                $session->set('my_cart', $cart);
            }

            foreach ($cart as $productId => $productQuantity) {
                $product = $repoP->findOneBy([
                    'id' => $productId,
                ]);

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

            $cartDetails = ['products' => $productsArray, 'totalsum' => $totalSum];
            $product = $repoP->findOneBy([
                'id' => $id,
            ]);

            $data = array(
                'status' => 'ok',
                'totalSum' => $totalSum,
                'quantity' => $singleProductQte,
                'productSum' =>  $product->getPrix() * $singleProductQte

            );
            return  new JsonResponse($data);
        } else {
            return $this->json('Error');
        }
    }

    /**
     * @Route("admin/product/featured/{id}" , name="is_featured_product", methods={"POST"})
     */
    public function clickAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repoP = $em->getRepository(Produit::class);
        $product = new Produit();
        $product = $repoP->findOneBy([
            'id' => $id,
        ]);

        if ($request->isMethod('post')) {

            $bookmark = $product->getFeatures();
            if ($bookmark == 0) {
                $featured = $product->setFeatures(1);
                $em->persist($featured);
            }
            if ($bookmark == 1) {
                $featured = $product->setFeatures(0);
                $em->persist($featured);
            }
            $em->flush();


            $data = array(
                'status' => 'ok',
                'featured' => $featured,
                'bookmark' => $bookmark,
            );
            return  new JsonResponse($data);
        }
        return $this->json('Error');
    }
}
