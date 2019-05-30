<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchController extends AbstractController
{
    /**
     *@Route("/search", name="search")
     */
    public function index()
    {
        
    }
    
    public function searchBar()
    {
        $form = $this->createFormBuilder(null)
            ->add('query', TextType::class)
            ->add('search', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();

        return $this->render('search/searchBar.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * This will remove formTypeName from the form
     * @return null
     */
    public function getBlockPrefix()
    {
        return null;
    }
}
