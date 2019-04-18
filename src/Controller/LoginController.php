<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        $em = $this->getDoctrine()->getManager();
        $repoC = $em->getRepository(Categorie::class);
        $categoriesMenu = $repoC->getCategories();

        return $this->render('login/login.html.twig', [
            'categoriesMenu' => $categoriesMenu
            
        ]);
    }
}
