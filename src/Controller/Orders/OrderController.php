<?php

namespace App\Controller\Orders;

use App\Entity\Produit;
use App\Entity\Commande;
use App\Form\OrdersFormType;
use App\Entity\CommandeProduit;
use Proxies\__CG__\App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    /**
     * @Route("/user/order", name="user_order", methods={"GET","POST"})
     */
    public function order(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repoP = $em->getRepository(Produit::class);

        $order = new Commande();

        // createOrderDBRecord
        $session = new Session();
        $cart = [];
        $totalSum = 0;

        if ($session->get('my_cart') == null) {
            $session->set('my_cart', $cart);
        } else {
            $cart = $session->get('my_cart');
        }

        if ($request->isMethod('post')) {
            $productQuantity = $request->request->get('qte');
            $productId = $request->request->get('product_id');

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
            $cartDetails = ['products' => $productsArray, 'totalsum' => $totalSum];


            if (is_object($product)) {
                $quantity = abs((int)$productQuantity);
                $sum += ($quantity * $product->getPrix());

                $orderProduct = new CommandeProduit();

                $orderProduct->setCommande($order);
                $orderProduct->setProduit($product);
                $orderProduct->setPrix($product->getPrix());
                $orderProduct->setQuantity($quantity);
                $em = $this->getDoctrine()->getManager();
                $em->persist($orderProduct);
                $order->addCommandeProduit($orderProduct);
            }
        }

        $user = $this->getUser();
        $order->setUtilisateur($user);
        $order->setPrixTotale($sum);



            // dump($product->getstock() - $quantity);

        //Form Order
        $form = $this->createForm(OrdersFormType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();
            $session->clear();

            $this->addFlash('success',  'Je vous remercie! Nous nous occupons de votre commande dès que possible!');
            return $this->redirectToRoute('user_account');
        }
        return $this->render('order/oders.html.twig', [
            'form' => $form->createView(),
            'order' => $order,
            'cartDetails' => $cartDetails,
            'orderProduct' => $orderProduct
        ]);
    }

    public function clearCart()
    {
        $response = new Response();
        $response->headers->clearSessions('cart');
        $response->sendHeaders();
    }
}
