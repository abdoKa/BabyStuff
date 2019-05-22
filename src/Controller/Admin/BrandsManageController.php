<?php

namespace App\Controller\Admin;

use App\Form\BrandsType;
use App\Entity\Fourniseur;
use App\Form\EditBrandType;
use Knp\Component\Pager\PaginatorInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BrandsManageController extends AbstractController

{
    /**
     * @Route("/admin/Brands", name="admin_brands")
     */
    public function admin_Bfournisseur(PaginatorInterface $paginator, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repoF = $em->getRepository(Fourniseur::class);

        $fournissuer = $repoF->findAll();


        $pagination = $paginator->paginate(
            $fournissuer,
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('admin/Admin_BrandsTwigs/brands.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/admin/brand/edit/{slug}", name="edit_brand", methods={"GET","POST"})
     */
    public function edit_brand(Request $request, Fourniseur $brand, $slug)
    {

        $em = $this->getDoctrine()->getManager();
        $brand = $em->getRepository(Fourniseur::class)->findOneBy(array('slug' => $slug));

        $brand->setImage(
            new File($this->getParameter('uploads_directory') . '/' . $brand->getImage())
        );

        dump($brand);

        $form = $this->createForm(EditBrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $brand = $form->getData();
            $file = $brand->getImage();

            if ($form->isSubmitted() && $form->isValid()) {
                $brand = $form->getData();
                $file = $brand->getImage();

                if ($file instanceof UploadedFile) {
                    $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                    $file->move(
                        $this->getParameter('uploads_directory'),
                        $fileName
                    );
                    $brand->setImage($fileName);
                }
                $brand->setImage(basename($brand->getImage()));
            }

            $em->persist($brand);
            $em->flush();
            $this->addFlash('info', $brand->getNom() . ' est modifer avec succée !');
            return $this->redirectToRoute('admin_brands');
        }



        return $this->render('Admin/Admin_BrandsTwigs/EditBrand.html.twig', [
            'brand' => $brand,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/brand/new", name="new_brand",  methods={"GET","POST"})
     */
    public function new_brand(Request $request)
    {
        $brand = new Fourniseur();

        $form = $this->createForm(BrandsType::class, $brand);

        $form->handleRequest($request);

        dump($brand);
        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();
            $fileName = md5(uniqid()) . '.' . $image->guessExtension();
            $image->move(
                $this->getParameter('uploads_directory'),
                $fileName
            );
            $brand->setImage($fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($brand);
            $this->addFlash('success', $brand->getNom() . ' est ajouter avec succée !');
            $entityManager->flush();

            return $this->redirectToRoute('admin_brands');
        }
        return $this->render('Admin/Admin_BrandsTwigs/newBrand.html.twig', array(
            'form' => $form->createView(),
            'brand' => $brand
        ));
    }

    /**
     * @Route("/admin/brand/detail/{slug}", name="brand_detail")
     */
    public function show_brand($slug)
    {

        $em = $this->getDoctrine()->getManager();
        $repoF = $em->getRepository(Fourniseur::class);

        $single_Brand = $repoF->findOneBy(array('slug' => $slug));
        dump($single_Brand);
        return $this->render('Admin/Admin_BrandsTwigs/brand_detail.html.twig', [
            'single_Brand' => $single_Brand,
        ]);
    }

    /**
     * @Route("admin/brand/delete/{slug}", name="brand_delete")
     */
    public function delete($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $repoP = $em->getRepository(Fourniseur::class);
        $brand = $repoP->findOneBy(array('slug' => $slug));

        $em->remove($brand);
        $em->flush();        
        $this->addFlash('delete', $brand->getNom() . ' est supprimer avec succée !');
        return $this->redirectToRoute('admin_brands');
    }
}
