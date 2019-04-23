<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Produit;

use Cocur\Slugify\Slugify;
use App\Form\ProduitType;


class ProductManageController extends AbstractController

{
    /**
     * @Route("/admin/product", name="admin_product")
     */
    public function admin_Bproduct(PaginatorInterface $paginator,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $repoP=$em->getRepository(Produit::class);
        $produit=$repoP->findAll();
        $pagination=$paginator->paginate(
            $produit,
            $request->query->getInt('page',1),9
        );
        
        return $this->render('admin/product.html.twig', [
            'pagination'=>$pagination,
            
        ]);
    }

    /**
     * @Route("/admin/new/product", name="new_product")
     * @Method({"GET", "POST"})
     */

     public function new_product(Request $request)
     {  
            $product=new Produit();

            $form = $this->createForm(ProduitType::class, $product);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                
                $product=$form->getData();
                
                $image=$form->get('image')->getData();
                $fileName = md5(uniqid()).'.'.$image->guessExtension();

                $image->move(
                    $this->getParameter('uploads_directory'),
                    $fileName
                );
              
                $product->setImage($fileName);
                $product->setFeatures(0);
                
                $entityManager =$this->getDoctrine()->getManager();
                $entityManager->persist($product);
                $entityManager->flush();

                return $this->redirectToRoute('admin_product');

                }

                
            return $this->render('admin/newProduct.html.twig',array(
                'form'=> $form->createView()
            ));
     }


}