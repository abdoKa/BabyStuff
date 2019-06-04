<?php

namespace App\Controller\Users;

use App\Entity\Commande;
use App\Entity\ProductLike;

use App\Form\EditUserType;
use App\Form\EditPasswordType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Produit;

class UserAccountController extends AbstractController
{
    /**
     * @Route("/user/account", name="user_account")
     */
    public function accout()
    {

        return $this->render('user_account/user_space.html.twig', []);
    }


    /**
     * @Route("/user/account/profile", name="user_profile")
     *
     */
    public function profile()
    {
        return $this->render('user_account/profile.html.twig', []);
    }

    /**
     * @Route("/user/account/profile/edit", name="user_profile_edit", methods={"GET","POST"})
     */
    public function editProfile(Request $request, UserInterface $currentUser)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(EditUserType::class, $currentUser);
        $form->handleRequest($request);

        $getPasswordFromInput = $form->get("confirm_password")->getData();

        $hash = $currentUser->getpassword();
        dump($getPasswordFromInput);
        dump($currentUser);

        if ($form->isSubmitted() && $form->isValid()) {
            if (password_verify($getPasswordFromInput, $hash)) {
                $em->persist($currentUser);
                $em->flush();
                $this->addFlash('info', $currentUser->getNom() . ' ' .  $currentUser->getPrenom() . ' , votre information est modifer avec succée !');
                return $this->redirectToRoute('user_profile');
            } else{
                $this->addFlash('error','mot de passe incorrect ,réessayer !');

            }
        }

        return $this->render('user_account/editProfile.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/user/account/password/edit", name="user_password_edit", methods={"GET","POST"})
     */
    public function editPassword(Request $request, UserInterface $currentUser, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $email = $currentUser->getEmail();
        $hash = $currentUser->getPassword();

        $form = $this->createForm(EditPasswordType::class, $currentUser, []);
        $form->handleRequest($request);

        dump($hash);
        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($currentUser, $currentUser->getPassword());
            $currentUser->setPassword($hash);

            $em->persist($currentUser);
            $em->flush();
            return $this->redirectToRoute('user_profile');
        }


        return $this->render('user_account/editPassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("user/order/list", name="user_orders_list")
     *
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


        return $this->render('user_account/userOrder.html.twig', [
            'userOrderList' => $userOrderList,
            'pagination' => $pagination
        ]);
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

        (int)$userId = $user->getId();

        $belongTo = $repoOrder->BelongsToUser($id, $userId);

        $pagination = $paginator->paginate(
            $detailOrder,
            $request->query->getInt('page', 1),
            5
        );

        if ($belongTo) {

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
     * @Route("/user/favorite/detail/{id}", name="user_favorite_detail")
     */
    public function userFav(PaginatorInterface $paginator, Request $request, $id, UserInterface $user)
    {
        $em = $this->getDoctrine()->getManager();
        $repoLike = $em->getRepository(ProductLike::class);
        $likes = $repoLike->findOneBy(array('id' => $id));

        (int)$userId = $user->getId();
        $belongTo = $repoLike->BelongsToUser($id, $userId);
        dump($likes);

        if ($belongTo) {
            return $this->render('user_account/favorite_detail.html.twig', [
                'likes' => $likes,
                // 'pagination' => $pagination,
            ]);
        } else {
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
        }
    }

    /**
     * @Route("/user/favorite/" , name="user_favorite")
     */

    public function favorite(PaginatorInterface $paginator, Request $request, UserInterface $currentUser)
    {
        $currentUser = $this->getUser()->getLikes();

        dump($currentUser);

        $pagination = $paginator->paginate(
            $currentUser,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('user_account/favorite.html.twig', [
            'pagination' => $pagination
        ]);
    }
}
