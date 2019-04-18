<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;
use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class ShopingController extends AbstractController
{
    /**
     * @Route("/panier", name="shopping")
     */
    public function bag_shoping(Request $request)
    {

        if ($request->isMethod('post')) {
            // your code
            
            $session = new Session();
            
            $cart=array();
            
            if($session->get('my_cart') == null)
            {
                $session->set('my_cart',$cart);
            }else{
                $cart=$session->get('my_cart');
            }
            $total=0;
            $listProducts=array();
            $quantity=$request->request->get('qte');
            $product_id=$request->request->get('product_id');

            $repository = $this->getDoctrine()->getRepository(Produit::class);
            $product0=$repository->findOneBy([
                'id' =>$product_id 
            ]);
            
                $prix=$product0->getPrix();
                $total_product=$prix * $quantity;
                
                $product=array(
                    'product_id'=>$product_id,
                    'quantity'=>$quantity,
                    'prix'=>$prix,
                    'total'=>$total_product
                );
            
        
                array_push($listProducts,$product);
                
                foreach ($listProducts as $product )
                {
                    $total+= $product['total'];
                }
                 $cart=array(
                     'listproducts'=>$listProducts,
                     'total'=>$total
                 );
               
        }

        $em =$this->getDoctrine()->getManager();
        $repoC =$em->getRepository(Categorie::class);
        $categoriesMenu =$repoC->getCategories();

         return $this->render('shopping/bag-shoping.html.twig',[
            'categoriesMenu' =>$categoriesMenu,
        ]);
        
    }
}