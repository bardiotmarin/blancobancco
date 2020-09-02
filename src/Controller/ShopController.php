<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{

    /**
     * @Route("/shop",name="shop")
     */
    Public function Shop(ProductsRepository $productsRepository)

    {
//        $product = $productsRepository->findBy(
//            ['produitsTypes' => 'capsule-1-TeeShirt']);
     return $this ->render("shop.html.twig",[
//         "product"=> $product
     ]);


    }


}