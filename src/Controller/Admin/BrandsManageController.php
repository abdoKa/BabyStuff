<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Fourniseur;


class BrandsManageController extends AbstractController

{
 /**
     * @Route("/admin/Brands", name="admin_brands")
     */
    public function admin_Bfournisseur(PaginatorInterface $paginator,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $repoF=$em->getRepository(Fourniseur::class);

        

        $fournissuer=$repoF->findAll();

        
        $pagination=$paginator->paginate(
            $fournissuer,
            $request->query->getInt('page',1),9
        );
        return $this->render('admin/brands.html.twig', [
           'pagination'=>$pagination
        ]);
    }
}