<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
//    ici  je cree ma route  pour ajouter mes produits
//
    /**
     * @Route("admin/add-product", name="add_product")
     */
//    ici je cree ma methodes , de requette au formulaire , avec request qui me servira ici a upload
//    Cet objet contient toutes les données possibles avec une requête http ( get , post , ect...)
//    je cree mon C du CRUD

    public function addProduct(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductFormType::class);
        $form->handleRequest($request);
        $product = new Product();

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManagers();
            $entityManager->persist($product);
            $entityManager->flush();
        }


        return $this->render('product-form.html.twig', [
            "form_title" => "Ajoutez un produit",
            "form_product" => $form->createView(),
        ]);
    }

//    ici Je cree mon R du CRUD
}
