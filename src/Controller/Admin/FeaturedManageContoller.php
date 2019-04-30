<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Produit;


class FeaturedManageContoller extends AbstractController
 {
 /**
     * @Route("/admin/featured", name="admin_featured")
     */
    public function admin_Bfeatures(PaginatorInterface $paginator,Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        $repoFea =$em->getRepository(Produit::class);
        $features =$repoFea->getAllB_Features();

        $pagination=$paginator->paginate(
            $features,
            $request->query->getInt('page',1),6
        );

        return $this->render('admin/B_featured.html.twig', [
            'pagination'=>$pagination
        ]);
    }   

}