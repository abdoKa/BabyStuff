<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function adminDashboard()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('admin/base-admin.html.twig', []); 

     }

    // // public function adminDashboard()
    // // {
    // //     $this->denyAccessUnlessGranted('ROLE_USER');

    // //     // or add an optional message - seen by developers
    // //     $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
    // // }
}
