<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{

    /**
     * @Route("/shop", name="product_shop")
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('shop.html.twig', [
            'products' => $productRepository->findAll(),
        ]);

    }

//    /**
//     * @Route ("/shop/{id}", name="shop_show")
//     */
//    public function BookShow (ProductRepository $productRepository, $id){
//
//        $product= $productRepository->find($id);
//
//        return $this -> render ("product/index.html.twig",[
//
//            "products"=> $product
//        ]);
//    }

    /**
     * @Route ("/shop/{id}", name="shop_show")
     */
    public function ShopShow (ProductRepository $productRepository, $id){

        $product= $productRepository->find($id);

        return $this -> render ("product/show.html.twig",[

            "product"=> $product
        ]);
    }


}