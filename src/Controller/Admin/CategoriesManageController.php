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


        return $this->render('admin/B_categories.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/admin/edit/{slug}", name="edit_categorie", methods={"GET","POST"})
     */
    public function edit_categorie(Request $request, Categorie $categorie, $slug): Response
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

        if ($form->isSubmitted() && $form->isValid()) {
            $categorie = $form->getData();
            $file = $categorie->getImage();

            if ($file instanceof UploadedFile) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('uploads_directory'),
                    $fileName
                );
                $categorie->setImage($fileName);
            }

            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('admin_categories');
        }


        return $this->render('Admin/editCategorie.html.twig', [
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
        return $this->render('Admin/newCategorie.html.twig', array(
            'form' => $form->createView(),
            'categorie' => $categorie
        ));
    }
}
