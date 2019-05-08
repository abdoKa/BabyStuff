<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Commande;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Proxies\__CG__\App\Entity\CommandeProduit;
use App\Entity\Produit;

class OrdersManageController extends AbstractController
{
    /**
     * @Route("/admin/orders", name="admin_orders")
     */
    public function admin_Bcommande(PaginatorInterface $paginator, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repoOrder = $em->getRepository(Commande::class);
        $order = $repoOrder->findAll();

        $pagination = $paginator->paginate(
            $order,
            $request->query->getInt('page', 1),
            9
        );
        // // dump($order);
        return $this->render('admin/order.html.twig', [
            'order' => $order,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/admin/orders/detail/{id}", name="order_detail")
     */
    public function show_order($id)
    {

        $em = $this->getDoctrine()->getManager();
        $repoOrder = $em->getRepository(Commande::class);

        $order = $repoOrder->findOneBy(array('id' => $id));

        $detailOrder =$order->getCommandeProduits();

        dump($order);
        dump($detailOrder);
        return $this->render('admin/order_detail.html.twig', [
            'order' => $order,
            'detailOrder' => $detailOrder,
        ]);
    }
}
