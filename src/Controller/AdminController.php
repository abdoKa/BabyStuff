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
        return $this->render('admin/base-admin.html.twig', [
           
        ]);
    }

    /**
     * @Route("/admin/fournisseur", name="admin_fournisseur")
     */
    public function admin_Bfournisseur()
    {
        return $this->render('admin/B_fournisseurlist.html.twig', [
           
        ]);
    }

    /**
     * @Route("/admin/commande", name="admin_commande")
     */
    public function admin_Bcommande()
    {
        return $this->render('admin/B-commande.html.twig', [
           
        ]);
    }
   
}
