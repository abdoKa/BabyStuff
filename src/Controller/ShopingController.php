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
     * @Route("/panier", name="shoping")
     */
    public function bag_shoping(Request $request)
    {
        $session = new Session();
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
    
        $product1=array(
            'product_id'=>1,
            'quantity'=>1,
            'prix'=>400,
            'total'=>400
        );

        array_push($listProducts,$product,$product1);
        
        
        
        
        foreach ($listProducts as $product )
        {
            $total+= $product['total'];
        }
         $cart[]=array(
             'listproducts'=>$listProducts,
             'total'=>$total
         );
        
         if(!$session->get('my_cart'))
         {
             
         }
         dump($session);
         die();
        
    }
}