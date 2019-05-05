<?php

namespace App\Controller\Users;

use App\Entity\Utilisateur;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserAccountController extends AbstractController
{
    /**
     * @Route("/user/account/{id}", name="user_account")
     */
    public function accout($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repoUser= $em->getRepository(Utilisateur::class);
        $user=$repoUser->findOneBy(array('id'=> $id));
        dump($user);

        return $this->render('user_account/user_space.html.twig', [
            'user' => $user,
        ]);

    }
}
