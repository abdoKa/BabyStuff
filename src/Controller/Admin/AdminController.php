<?php

namespace App\Controller\Admin;

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
     * @Route("/admin/user", name="admin_user_list")
     */
    public function admin_BuserList()
    {
        return $this->render('admin/B_userList.html.twig', [
           
        ]);
    }

   

     
    
}
