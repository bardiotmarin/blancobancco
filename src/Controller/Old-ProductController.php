<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
    public function AdminAddShop(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // je créé une nouvelle instance de l'entité Product
        $product = new Product();

        // je récupère le gabarit de formulaire de
        // l'entité Product, créé avec la commande make:form
        // et je le stocke dans une variable $Form
        $form = $this->createForm(ProductType::class, $product);

        // on prend les données de la requête (classe Request)
        //et on les "envoie" à notre formulaire
        $form->handleRequest($request);
        // si le formulaire a été envoyé et que les données sont valides
        // par rapport à celles attendues alors je persiste le produits

        if ($form->isSubmitted() && $form->isValid()) {

            // vu que le champs bookCover de mon formulaire est en mapped false
            // je gère moi même l'enregistrment de la valeur de cet input
            // https://symfony.com/doc/current/controller/upload_file.html

            // je récupère l'image uploadée
            $productImageFile = $form->get('image')->getData();
            $name = $form->get('name')->getData();

            // s'il y a bien une image uploadée dans le formulaire
            if ($productImageFile) {

                // je récupère le nom de l'image, lui rajoute le nom du produit - un id unique qui permet de ne pas avoir des doublon
                // et grâce à son nom original, je gènère un nouveau qui sera unique
                // pour éviter d'avoir des doublons de noms d'image en BDD


                $originalImageName = $name.'-'.uniqid(). '.' . $productImageFile->guessExtension();

                // Permet de nettoyer l'url des accents, et autres espaces indésirable
                $originalImageName = filter_var(strip_tags($originalImageName), FILTER_SANITIZE_URL);

                // j'utilise un bloc de try and catch
                // qui agit comme une conditions, mais si le bloc try échoue, ça
                // soulève une erreur, qu'on peut gérer avec le catch

                // je prends l'image uploadée
                // et je la déplace dans un dossier (dans public) + je la renomme avec
                // le nom unique générée
                // j'utilise un parametre (défini dans services.yaml) pour savoir
                // dans quel dossier je la déplace
                // un parametre = une sorte de variable globale
                try {
                    $productImageFile->move(
                        $this->getParameter('product_image_directory'),
                        $originalImageName
                    );

                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                // je sauvegarde dans la colonne bookCover le nom de mon image
                $product->setImage($originalImageName);
            }


            // J'envoi à la base de donnée
            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash('success', 'Produit enregistré');
        }


//return $this->redirectToRoute('product_index');
        return $this->render('product/new.html.twig', [

            'form' => $form->createView()]);

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
