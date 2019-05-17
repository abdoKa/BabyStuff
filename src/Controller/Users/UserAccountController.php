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
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\CssSelector\Parser\Token;

class UserAccountController extends AbstractController
{
    /**
     * @Route("/user/account", name="user_account")
     */
    public function accout()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('user_account/user_space.html.twig', []);
    }



    /**
     * @Route("/user/account/profile", name="user_profile")
     *
     */
    public function profile()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('user_account/profile.html.twig', []);
    }

    /**
     * @Route("/user/account/profile/{id}/edit", name="user_profile_edit", methods={"GET","POST"})
     */
    public function editProfile(Request $request, $id, UserInterface $currentUser)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $em = $this->getDoctrine()->getManager();
        $repoUser = $em->getRepository(Utilisateur::class);
        $user = $repoUser->findOneBy(array('id' => $id));

        $userId = $currentUser->getId();
        $belongTo = $repoUser->BelongsToUser($id);
        dump($belongTo[0]->getId() == $userId);
        dump($belongTo);
        dump($userId);

        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($belongTo[0]->getId() == $userId) {

            if ($form->isSubmitted() && $form->isValid()) {

                $em->persist($user);
                $em->flush();
            }

            return $this->render('user_account/editProfile.html.twig', [
                'form' => $form->createView(),
            ]);
        } else {
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
        }
    }


    /**
     * @Route("user/order/list", name="user_orders_list")
     */
    public function UserOrderList(PaginatorInterface $paginator, Request $request, UserInterface $userOrderList)
    {
        $userOrderList = $this->getUser()->getCommandes();
        dump($userOrderList);

        $pagination = $paginator->paginate(
            $userOrderList,
            $request->query->getInt('page', 1),
            6
        );

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('user_account/userOrder.html.twig', [
            'userOrderList' =>$userOrderList,
            'pagination'=>$pagination
        ]);
    }

    /**
     * @Route("/user/orders/detail/{id}", name="user_detail")
     */
    public function show_order(PaginatorInterface $paginator, Request $request, $id, UserInterface $user)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $em = $this->getDoctrine()->getManager();
        $repoOrder = $em->getRepository(Commande::class);
        $order = $repoOrder->findOneBy(array('id' => $id));
        $detailOrder = $order->getCommandeProduits();

        $userId = $user->getId();
        $belongTo = $repoOrder->BelongsToUser($id);
        dump($belongTo[0]->getUtilisateur()->getId() == $userId);
        dump($userId);

        $pagination = $paginator->paginate(
            $detailOrder,
            $request->query->getInt('page', 1),
            5
        );

        if ($belongTo[0]->getUtilisateur()->getId() == $userId) {

            return $this->render('user_account/user_detail.html.twig', [
                'order' => $order,
                'detailOrder' => $detailOrder,
                'pagination' => $pagination
            ]);
        } else {
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
        }
    }

    /**
     * @Route("/user/favorite/" , name="user_favorite")
     */

    public function favorite()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('user_account/favorite.html.twig', []);
    }
}
