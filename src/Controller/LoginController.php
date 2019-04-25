<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Utilisateur;
use App\Form\RegistraionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Flex\Path;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="security_login", methods={"GET", "POST"})
     */
    public function login()
    {
        return $this->render('login/login.html.twig', [
            
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {}

    /**
     * @Route("/inscrire", name="login_registration")
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder)
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
            return $this->redirectToRoute('security_login');
        }
        return $this->render('login/register.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
