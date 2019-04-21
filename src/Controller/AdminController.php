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
   
    /**
     * @Route("/admin/product", name="admin_product")
     */
    public function admin_Bproduct()
    {
        return $this->render('admin/B_Product.html.twig', [
           
        ]);
    }

    /**
     * @Route("/admin/user", name="admin_user_list")
     */
    public function admin_BuserList()
    {
        return $this->render('admin/B_userList.html.twig', [
           
        ]);
    }

    /**
     * @Route("/admin/categories", name="admin_categories")
     */
    public function admin_Bcategories()
    {
        return $this->render('admin/B_categories.html.twig', [
           
        ]);
    }

     /**
     * @Route("/admin/featured", name="admin_featured")
     */
    public function admin_Bfeatures()
    {
        return $this->render('admin/B_featured.html.twig', [
           
        ]);
    }
    
}
