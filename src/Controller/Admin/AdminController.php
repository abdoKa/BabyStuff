<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function adminDashboard()
    {
        return $this->render('admin/base-admin.html.twig', []); 

    }

}
