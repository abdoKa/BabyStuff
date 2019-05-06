<?php

namespace App\Controller\Orders;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Commande;
use App\Form\OrdersFormType;

class OrderController extends AbstractController
{
    /**
     * @Route("/user/order", name="user_giorder", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function order(Request $request)
    {
        $order = new Commande();

        $form =$this->createForm(OrdersFormType::class,$order);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager =$this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('user_account');
        }
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('order/oders.html.twig', [
            'form' => $form->createView(),
            'order'=>$order
        ]);
    }
}
