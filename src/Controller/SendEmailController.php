<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class SendEmailController extends AbstractController
{

    public function index($name, \Swift_Mailer $mailer, UserInterface $currentUser)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('abdellalikabou39@gmail.com')
            ->setTo('abdellalikabou39@gmail.com')
            ->setBody(
                $this->renderView(
                    'send_email/igetEmailAfterRegistration.html.twig',
                    ['name' => $name]
                ),
                'text/html'
            );
        $mailer->send($message);

    }
}
