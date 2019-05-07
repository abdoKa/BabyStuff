<?php

namespace App\Controller\Orders;

use App\Entity\Produit;
use App\Entity\Commande;
use App\Form\OrdersFormType;
use App\Entity\CommandeProduit;
use Proxies\__CG__\App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    /**
     * @Route("/user/order", name="user_giorder", methods={"GET","POST"})
     */
    public function order(Request $request)
    {

        $order = new Commande();

        // createOrderDBRecord
        $session = $request->getSession();
        $cart = [];

        $em = $this->getDoctrine()->getManager();
        $repoP = $em->getRepository(Produit::class);
        if ($session->get('my_cart') == null) {
            $session->set('my_cart', $cart);
        } else {
            $cart = $session->get('my_cart');
        }

        

        $sum = 0; //total control sum of the order
        foreach ($cart as $productId => $productQuantity) {
            $product = $repoP->find((int)$productId);
            if (is_object($product)) {
                $quantity = abs((int)$productQuantity);
                $sum += ($quantity * $product->getPrix());

                $orderProduct = new CommandeProduit();

                $orderProduct->setCommande($order);
                $orderProduct->setProduit($product);
                $orderProduct->setPrix($product->getPrix());
                $orderProduct->setQuantity($quantity);
                // die();
                $em = $this->getDoctrine()->getManager();
                $em->persist($orderProduct);

                $order->addCommandeProduit($orderProduct);
                dump($orderProduct);
                // // dump($orderProduct);
                // // die();
            }
        }
        $cartDetails = ['products' => $product, 'totalsum' => $sum];

        $user = $this->getUser();
        $order->setUtilisateur($user);
       
        $order->setPrixTotale($sum);

        //Form Order
        $form = $this->createForm(OrdersFormType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();
            $session->clear();

            return $this->redirectToRoute('user_account');
        }
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('order/oders.html.twig', [
            'form' => $form->createView(),
            'order' => $order,
            'cartDetails' => $cartDetails
        ]);
    }
    public function clearCart()
    {
        $response = new Response();
        $response->headers->clearSessions('cart');
        $response->sendHeaders();
    }

   
}
