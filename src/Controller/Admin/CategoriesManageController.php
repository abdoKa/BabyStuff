<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;


use App\Entity\Categorie;



class CategoriesManageController extends AbstractController

{
     /**
     * @Route("/admin/categories", name="admin_categories")
     */
    public function admin_Bcategories(PaginatorInterface $paginator,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $repoC=$em->getRepository(Categorie::class);
        $categories=$repoC->findAll();

        
        $pagination=$paginator->paginate(
            $categories,
            $request->query->getInt('page',1),9
        );


        return $this->render('admin/B_categories.html.twig', [
           'pagination'=>$pagination
        ]);
    }
}