<?php

namespace App\Controller\Users;

use App\Entity\Commande;

use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\EditUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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

    /**
     * @Route("/user/account/settings", name="user_setting")
     * @IsGranted("ROLE_USER")
     */
    public function settings()
    {
        return $this->render('user_account/settings.html.twig', []);
    }

    /**
     * @Route("/user/account/profile", name="user_profile")
     * @IsGranted("ROLE_USER")
     */
    public function profile()
    {
        return $this->render('user_account/profile.html.twig', []);
    }

    /**
     * @Route("/user/account/profile/edit", name="user_profile_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function editProfile(Request $request, Utilisateur $user)
    {

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();
        }

        return $this->render('user_account/editProfile.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("user/order/list", name="user_orders_list")
     * @IsGranted("ROLE_USER")
     */
    public function UserOrderList(PaginatorInterface $paginator, Request $request)
    {


        return $this->render('user_account/userOrder.html.twig', []);
    }

    /**
     * @Route("/user/orders/detail/{id}", name="user_detail")
     */
    public function show_order(PaginatorInterface $paginator, Request $request, $id, UserInterface $user)
    {
        $em = $this->getDoctrine()->getManager();
        $repoOrder = $em->getRepository(Commande::class);
        $order = $repoOrder->findOneBy(array('id' => $id));
        $detailOrder = $order->getCommandeProduits();

        $userId = $user->getId();
        $belongTo = $repoOrder->BelongsToUser($id);
        dump($belongTo[0]->getUtilisateur()->getId() == $userId );
        dump($userId);
       

        if($belongTo[0]->getUtilisateur()->getId() == $userId ){

            return $this->render('user_account/user_detail.html.twig', [
                'order' => $order,
                'detailOrder' => $detailOrder,
            ]);
        }else{
            return $this->redirectToRoute('home');
        }

       
    }
}
