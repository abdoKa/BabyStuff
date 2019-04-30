<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;

use App\Form\CategorieType;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\EditCategorieType;

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
            $request->query->getInt('page', 1),
            9
        );

        dump($pagination);
        return $this->render('admin/Admin_CategorieTwigs/B_categories.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/admin/{slug}/edit", name="edit_categorie", methods={"GET","POST"})
     */
    public function edit_categorie(Request $request, Categorie $categorie, $slug)
    {

        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository(Categorie::class)->findOneBy(array('slug' => $slug));

        dump($categorie);
        if ($categorie == null) {
            return $this->render(
                'admin/NotFound.html.twig'

            );
        }

        $form = $this->createForm(EditCategorieType::class, $categorie);
        $form->handleRequest($request);

        dump($categorie);              
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

        dump($categorie);
        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();
            $fileName = md5(uniqid()) . '.' . $image->guessExtension();
            $image->move(
                $this->getParameter('uploads_directory'),
                $fileName
            );
            $categorie->setImage($fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('admin_categories');
        }
        return $this->render('Admin/Admin_CategorieTwigs/newCategorie.html.twig', array(
            'form' => $form->createView(),
            'categorie' => $categorie
        ));
    }

    /**
     * @Route("/admin/detail/{slug}", name="categorie_detail")
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
     * @Route("admin/detail/delete/{slug}", name="categorie_delete")
     */
    public function delete($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $repoP = $em->getRepository(Categorie::class);
        $categorie = $repoP->findOneBy(array('slug' => $slug));

        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute('admin_categories');
    }
}
