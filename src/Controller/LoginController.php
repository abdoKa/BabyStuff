<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;
use App\Form\RegistraionType;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
     * @Route("/inscrire", name="login_registration")
     */
    public function registration(Request $request,UserPasswordEncoderInterface  $encoder)
    {
        $utilisateur = new Utilisateur();
        $form=$this->createForm(RegistraionType::class, $utilisateur);

        $form->handleRequest($request);
        
        dump($utilisateur);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());

            $utilisateur->setPassword($hash);

            $entityManager =$this->getDoctrine()->getManager();
            $entityManager->persist($utilisateur);
            $entityManager->flush();
        }
        return $this->render('login/register.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
