<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use App\Form\editPType;
use App\Entity\Categorie;
use App\Form\ProduitType;


use App\Form\EditProductType;
use Gedmo\Mapping\Annotation\Slug;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProductManageController extends AbstractController

{
    /**
     * @Route("/admin/product", name="admin_product")
     */
    public function admin_Bproduct(PaginatorInterface $paginator, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repoP = $em->getRepository(Produit::class);
        $q = $request->query->get('q');
        $queryBuilder = $repoP->getWithSearch(trim($q));

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('Admin/Admine_ProductsTwigs/product.html.twig', [
            'pagination' => $pagination,
            // 'product'=>$product
        ]);
    }


    /**
     * @Route("/admin/edit/{slug}", name="product_edit", methods={"GET","POST"})
     */
    public function edit_product(Request $request, Produit $product, $slug): Response
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Produit::class)->findOneBy(array('slug' => $slug));

        $product->setImage(
            new File($this->getParameter('uploads_directory') . '/' . $product->getImage())
        );

        // $product->setImage(basename($product->getImage()));


        $form = $this->createForm(EditProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $product = $form->getData();
            $file = $product->getImage();
            if ($file instanceof UploadedFile) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('uploads_directory'),
                    $fileName
                );

                $product->setImage($fileName);
                // $product->setImage(basename($product->getImage()));
            }
            $product->setImage(basename($product->getImage()));

            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('admin_product');
            $this->addFlash('info', $product->getNom() . ' est modifer avec succée !');
        }



        return $this->render('Admin/Admine_ProductsTwigs/edit_product.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/new/product", name="new_product",  methods={"GET","POST"})
     */

    public function new_product(Request $request)
    {
        $product = new Produit();
        $form = $this->createForm(ProduitType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $product->getImage();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('uploads_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            $product->setImage($fileName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('admin_product');
            $this->addFlash('success', $product->getNom() . ' est ajouté avec succée !');
        }
        return $this->render('Admin/Admine_ProductsTwigs/newProduct.html.twig', array(
            'form' => $form->createView(),
            'product' => $product
        ));
    }
    /**
     * @Route("admin/product/delete/{slug}", name="product_delete")
     */
    public function delete($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $repoP = $em->getRepository(Produit::class);
        $product = $repoP->findOneBy(array('slug' => $slug));

        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute('admin_product');
        $this->addFlash('delete', $product->getNom() . ' est supprimer avec succée !');
    }

    /**
     * @Route("/admin/product/{slug}", name="product_detail")
     */
    public function show_product($slug)
    {

        $em = $this->getDoctrine()->getManager();
        $repoF = $em->getRepository(Produit::class);

        $single_p = $repoF->findOneBy(array('slug' => $slug));
        $fournisseur = $single_p->getFourniseur();

        $repoC = $em->getRepository(Categorie::class);
        $categoriesMenu = $repoC->getCategories();
        return $this->render('Admin/Admine_ProductsTwigs/prduct_detail.html.twig', [
            'single_p' => $single_p,
            'categoriesMenu' => $categoriesMenu,
            'fournisseur' => $fournisseur
        ]);
    }
}
