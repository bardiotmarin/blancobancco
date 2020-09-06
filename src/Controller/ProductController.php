<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/admin/shop", name="product_index")
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/add", name="add_product")
     */
    public function AdminAddShop(Request $request,
                                 EntityManagerInterface $entityManager,
                                 SluggerInterface $slugger): Response
    {
        // je créé une nouvelle instance de l'entité Book
        $product = new Product();

        // je récupère le gabarit de formulaire de
        // l'entité Product, créé avec la commande make:form
        // et je le stocke dans une variable $Form
        $form = $this->createForm(ProductType::class, $product);

        // on prend les données de la requête (classe Request)
        //et on les "envoie" à notre formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
        // si le formulaire a été envoyé et que les données sont valides
        // par rapport à celles attendues alors je persiste le produits
        if($productform -> isSubmitted() && $productform -> isValid()){

        // vu que le champs bookCover de mon formulaire est en mapped false
        // je gère moi même l'enregistrment de la valeur de cet input
        // https://symfony.com/doc/current/controller/upload_file.html

        // je récupère l'image uploadée
        $productImageFile = $productform->get('productImage')->getData();
        if

    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index');
    }

}
