<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/product", name="app_catalog_")
 * 
 * site.com/products            => Affiche la liste des produits
 * site.com/product             => Creer un produit
 * site.com/product/{id}        => Afficher le detail d'un produit
 * site.com/product/{id}/edit   => Modifier un produit
 * site.com/product/{id}/delete => Supprime un produit
 */
class CatalogController extends AbstractController
{
    /**
     * Affiche la liste des produits
     * 
     * url ex: /products
     * name: app_catalog_index
     * 
     * @Route("s", name="index")
     */
    public function index(): Response
    {
        return $this->render('catalog/index.html.twig', [
        ]);
    }

    /**
     * Ajouter un produit dans la bdd
     * 
     * url ex: /product
     * name: app_catalog_create
     * 
     * @Route("", name="create")
     */
    public function create(Request $request, ValidatorInterface $validator): Response
    {
        $errors = [];

        // Create Form
        // --

        // Initialiser le produit
        $product = new Product;

        
        // Construction du formulaire
        $form = $this->createForm(ProductType::class, $product);

        // Handle the request
        $form->handleRequest($request);

        // Catch form submission
        if ( $form->isSubmitted() ) 
        {
            // Handle form errors
            $errors = $validator->validate( $product );

            // si le form est valid
            if ( $form->isValid() )
            {
                // dd( $product );

                // enregistrement en bdd
                $en = $this->getDoctrine()->getManager();
                $en->persist( $product );
                $en->flush();

                // rediriger utilisateur
                return $this->redirectToRoute('app_catalog_index');
            }
        }

        // Préparation du formulaire pour la vue
        $form = $form->createView();

        // Response HTTP
        // --
        return $this->render('catalog/create.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * Afficher le detail d'un produit
     * 
     * url ex: /product
     * name: app_catalog_read
     * 
     * @Route("/{id}", name="read")
     */
    public function read(int $id): Response
    {

    }

    /**
     * Modifier la fiche d'un produit
     * 
     * url ex: /product
     * name: app_catalog_update
     * 
     * @Route("/{id}/edit", name="update")
     */
    public function update(int $id): Response
    {
        
    }

    /**
     * Supprimer la fiche d'un produit
     * 
     * url ex: /product
     * name: app_catalog_delete
     * 
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(int $id): Response
    {

    }
}
