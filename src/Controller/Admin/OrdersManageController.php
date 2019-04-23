<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class OrdersManageController extends AbstractController
 {
     /**
     * @Route("/admin/orders", name="admin_orders")
     */
    public function admin_Bcommande()
    {
        return $this->render('order.html.twig', [
           
        ]);
    }

 }