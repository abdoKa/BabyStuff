<?php

namespace App\Controller\Orders;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    /**
     * @Route("/user/order", name="order")
     * @IsGranted("ROLE_USER")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('order/oders.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }
}
