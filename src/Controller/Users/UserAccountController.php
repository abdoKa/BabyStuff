<?php

namespace App\Controller\Users;

use App\Entity\Utilisateur;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserAccountController extends AbstractController
{
    /**
     * @Route("/user/account", name="user_account")
     *  @IsGranted("ROLE_USER")
     */
    public function accout()
    {

        return $this->render('user_account/user_space.html.twig', []);
    }
}
