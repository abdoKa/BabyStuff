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
        return $this->render('login/login.html.twig', [
            
        ]);
    }

    /**
     * @Route("/inscrire", name="registre")
     */
    public function insrire()
    {
        return $this->render('login/register.html.twig', [
            
        ]);
    }
}
