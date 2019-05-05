<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistraionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils):Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $this->redirectToRoute('home');
        return $this->render('login/simple_login.html.twig', [
            'error'=>$error,
            'last_username'=>$lastUsername
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {}

    /**
     * @Route("/registration", name="login_registration" , methods={"GET", "POST"})
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $utilisateur = new Utilisateur();

        $form=$this->createForm(RegistraionType::class, $utilisateur);

        $form->handleRequest($request);
        
        
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
