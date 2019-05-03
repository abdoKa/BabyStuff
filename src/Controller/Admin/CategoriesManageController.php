<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;


use App\Form\EditCategorieType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\CategorieType;

class CategoriesManageController extends AbstractController

{
    /**
     * @Route("/admin/categories", name="admin_categories")
     */
    public function admin_Bcategories(PaginatorInterface $paginator, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repoC = $em->getRepository(Categorie::class);
        $categories = $repoC->findAll();


        $pagination = $paginator->paginate(
            $categories,
            $request->query->getInt('page', 1),9
        );

        return $this->render('admin/Admin_CategorieTwigs/B_categories.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/admin/categories/edit/{slug}", name="edit_categorie", methods={"GET","POST"})
     */
    public function edit_categorie(Request $request, Categorie $categorie, $slug):Response
    {

        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository(Categorie::class)->findOneBy(array('slug' => $slug));

        if ($categorie == null) {
            return $this->render(
                'admin/NotFound.html.twig'

            );
        }

        $form = $this->createForm(EditCategorieType::class, $categorie);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

        
            $categorie = $form->getData();
            $file = $categorie->getImage();

            if ($file instanceof UploadedFile) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('uploads_directory'),
                    $fileName
                );
                $categorie->setImage($fileName);
            }
            
            $em->persist($categorie);
            $em->flush();
            $this->addFlash('info','ce produit est modifer avec succée !');
            return $this->redirectToRoute('admin_categories');

        }


        return $this->render('Admin/Admin_CategorieTwigs/editCategorie.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/new/categorie", name="new_categorie",  methods={"GET","POST"})
     */
    public function new_categorie(Request $request)
    {
        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            
            $image=$form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$image->guessExtension();
            $image->move(
                $this->getParameter('uploads_directory'),
                $fileName
            );
            $categorie->setImage($fileName);                
            $entityManager =$this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();
            $this->addFlash('success', 'ce Catégorie est ajouté avec succée !');
            return $this->redirectToRoute('admin_categories');

            }
        return $this->render('Admin/Admin_CategorieTwigs/newCategorie.html.twig', array(
            'form' => $form->createView(),
            'categorie' => $categorie
        ));
    }

    /**
     * @Route("/admin/categories/detail/{slug}", name="categorie_detail")
     */
    public function show_categorie($slug)
    {

        $em = $this->getDoctrine()->getManager();
        $repoF = $em->getRepository(Categorie::class);

        $single_C = $repoF->findOneBy(array('slug' => $slug));
        dump($single_C);
        return $this->render('Admin/Admin_CategorieTwigs/categorie_detail.html.twig', [
            'single_C' => $single_C,
        ]);
    }

    /**
     * @Route("admin/categorie/delete/{slug}", name="categorie_delete")
     */
    public function delete($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $repoP = $em->getRepository(Categorie::class);
        $categorie = $repoP->findOneBy(array('slug' => $slug));

        $em->remove($categorie);
        $this->addFlash('delete','Ce catégorie est supprimer avec succée !');
        $em->flush();
        return $this->redirectToRoute('admin_categories');
    }
}
