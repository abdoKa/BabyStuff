<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use App\Entity\Produit;
use App\Entity\Fourniseur;
use App\Entity\Categorie;
use Knp\Component\Pager\PaginatorInterface;
use Cocur\Slugify\Slugify;
use App\Form\ProduitType;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/base-admin.html.twig', [
           
        ]);
    }

    /**
     * @Route("/admin/fournisseur", name="admin_fournisseur")
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
        return $this->render('admin/B_fournisseurlist.html.twig', [
           'pagination'=>$pagination
        ]);
    }

    /**
     * @Route("/admin/commande", name="admin_commande")
     */
    public function admin_Bcommande()
    {
        return $this->render('admin/B-commande.html.twig', [
           
        ]);
    }
   
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
        
        return $this->render('admin/B_Product.html.twig', [
            'pagination'=>$pagination,
            
        ]);
    }

    /**
     * @Route("/admin/new", name="new_product")
     * @Method({"GET", "POST"})
     */

     public function new_product(Request $request)
     {  
            $product=new Produit();
            $slugify = new Slugify();

            $form = $this->createForm(ProduitType::class, $product);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                
                $product=$form->getData();
                
                $image=$product->getImage();
                $uploads_directory=$this->getParameter('uploads_directory');

                $file_name= md5(uniqid()).'.'.$image->guessExtension();

                $image->move(
                    $uploads_directory,
                    $file_name
                );
                $slug = $slugify->slugify($product->getNom());
                $product->setSlug($slug);
                $product->setImage($file_name);
                $product->setDateAjout(new \DateTime("now"));
                $product->setDateModif(new \DateTime("now"));
                $product->setFeatures(0);

                $entityManager =$this->getDoctrine()->getManager();
                $entityManager->persist($product);
                $entityManager->flush();

                }


            return $this->render('admin/newProduct.html.twig',array(
                'form'=> $form->createView()
            ));
     }

    /**
     * @Route("/admin/user", name="admin_user_list")
     */
    public function admin_BuserList()
    {
        return $this->render('admin/B_userList.html.twig', [
           
        ]);
    }

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
            $request->query->getInt('page',1),9
        );

        return $this->render('admin/B_featured.html.twig', [
            'pagination'=>$pagination
        ]);
    }
    
}
