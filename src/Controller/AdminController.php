<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('base-admin.html.twig', [
           
        ]);
    }

    /**
     * @Route("/admin/produit", name="admin_produit")
     */ 
    public function show_products()
    {
        return $this->render('admin/admin-produit.html.twig');
    }
}
