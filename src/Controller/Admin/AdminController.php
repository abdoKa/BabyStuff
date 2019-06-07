<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin") 
     * 
     */
    public function adminDashboard(PaginatorInterface $paginator, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repoOrder = $em->getRepository(Commande::class);
        $order = $repoOrder->findAll();

        $pagination = $paginator->paginate(
            $order,
            $request->query->getInt('page', 1),9
        );
      

        return $this->render('admin/base-admin.html.twig', [
            'order'=>$order,
            'pagination'=>$pagination
        ]);
    }
}
