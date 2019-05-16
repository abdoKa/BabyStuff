<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;


    use App\Entity\Produit;
    use App\Entity\Categorie;

    use App\Form\ProduitType;
    use Symfony\Component\HttpFoundation\Response;
    use App\Form\editPType;
    use Symfony\Component\HttpFoundation\File\UploadedFile;
    use Gedmo\Mapping\Annotation\Slug;
use App\Entity\Utilisateur;
use App\Entity\Commande;

class UserManageController extends AbstractController

{
    /**
     * @Route("/admin/user", name="admin_user_list")
     */
    public function admin_BuserList()
    {
        $em = $this->getDoctrine()->getManager();
        $repoC = $em->getRepository(Utilisateur::class);

        $user = $repoC->findAll();

        return $this->render('admin/Admin_UsersTwigs/B_userList.html.twig', [
            'users' => $user,

        ]);
    }

    /**
     * @Route("/admin/user/detail/{id}" , name="user_detail")
     */

    public function user_detail($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repoU = $em->getRepository(Utilisateur::class);


        $user_detail = $repoU->findOneBy(array('id' => $id));
        dump($user_detail);
        return $this->render('admin/Admin_UsersTwigs/user_detail.html.twig', [
            'user_detail' => $user_detail,
        ]);
    }

   /**
         * @Route("/admin/orders/user/detail/{id}", name="userOrderDetail")
     */
    public function show_order($id)
    {

        $em = $this->getDoctrine()->getManager();
        $repoUser = $em->getRepository(Utilisateur::class);

        $users = $repoUser->findOneBy(array('id' => $id));
        $order =$users->getCommandes();


        dump($order);
        return $this->render('admin/Admin_UsersTwigs/userOrderDetail.html.twig', [
            'users' => $users,
            'order'=>$order
        ]);
    }

    
}
