<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BabyProductsController extends AbstractController
{
    /**
     * @Route("/babyProducts", name="baby_products")
     */
    public function index()
    {
        return $this->render('baby_products/index.html.twig', [
            'controller_name' => 'BabyProductsController',
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('baby_products/home.html.twig');
    }

    /**
     * @Route("/about-us", name="about")
     */
    public function about()
    {
        return $this->render('baby_products/about.html.twig');
    }

    

}
