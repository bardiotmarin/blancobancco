<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{

    /**
     * @Route("/shop",name="shop")
     */
    Public function Shop(ProductRepository $productRepository)

    {
//        $product = $productsRepository->findBy(
//            ['produitsTypes' => 'capsule-1-TeeShirt']);
     return $this ->render("shop.html.twig",[
//         "product"=> $product
     ]);


    }


}