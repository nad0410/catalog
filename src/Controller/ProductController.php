<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/product", name="app_product_")
 * 
 * site.com/products            => Affiche la liste des produits
 * site.com/product             => Creer un produit
 * site.com/product/{id}        => Afficher le detail d'un produit
 * site.com/product/{id}/edit   => Modifier un produit
 * site.com/product/{id}/delete => Supprime un produit
 */
class ProductController extends AbstractController
{
    /**
     * Affiche la liste des produits
     * 
     * url ex: /products
     * name: app_product_index
     * 
     * @Route("s", name="index", methods={"HEAD","GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * Ajouter un produit dans la bdd
     * 
     * url ex: /product
     * name: app_product_create
     * 
     * @Route("", name="create", methods={"HEAD", "GET", "POST"})
     */
    public function create(ManagerRegistry $doctrine, Request $request, ValidatorInterface $validator): Response
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
           
            // recuperer les donnees en tableau
            $submittedToken = $request->request->get('product')['_csrf_product_token']; 

            if (! $this->isCsrfTokenValid('_csrf_product_token_id', $submittedToken))
            {
                dd("Erreur de token");
            }
            
            // Handle form errors
            $errors = $validator->validate( $product );

            // si le form est valid
            if ( $form->isValid() )
            {
                // enregistrement en bdd
                $en = $doctrine->getManager();
                $en->persist( $product );
                $en->flush();

                // rediriger utilisateur
                return $this->redirectToRoute('app_product_index');
                
            }
        }

        // Pr??paration du formulaire pour la vue
        $form = $form->createView();

        // Response HTTP
        // --
        return $this->render('product/create.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * Afficher le detail d'un produit
     * 
     * url ex: /product
     * name: app_product_read
     * 
     * @Route("/{id}", name="read", methods={"HEAD", "GET"})
     */
    public function read(Product $product): Response
    {
        return $this->render('product/read.html.twig', [
            'product' => $product
        ]);
    }

    /**
     * Modifier la fiche d'un produit
     * 
     * url ex: /product
     * name: app_product_update
     * 
     * @Route("/{id}/edit", name="update", methods={"HEAD", "GET", "POST"})
     */
    public function update(Product $product, ManagerRegistry $doctrine, Request $request, ValidatorInterface $validator): Response
    {   
        $errors = [];
        // Construction du formulaire
        $form = $this->createForm(ProductType::class, $product);

        // R??cup??ration de la requete HTTP
        $form->handleRequest($request);

        // Test la soumission du formulaire
        if ($form->isSubmitted())        
        {
         
            // R??cup??ration du CSRF Token
            $submittedToken = $request->request->get('product')['_csrf_product_token'];

            // V??rifier l'int??grit?? du formulaire (CSRF Token)
            if ( ! $this->isCsrfTokenValid('_csrf_product_token_id', $submittedToken) )
            {
                dd("Erreur de token");
            }
            
            // Validation du formulaire
            $errors = $validator->validate( $product );

            if ($form->isValid())
            {
                // Ajouter des valeurs par d??faut

                // Enregistrement des donn??es en BDD
                $em = $doctrine->getManager();
                $em->persist( $product );
                $em->flush();



                // Redirection de l'utilisateur vers la page du d??tail de la cat??gorie
                return $this->redirectToRoute('app_product_read', [
                    'id' => $product->getId()
                ]);
            }
        }

        // Pr??paration du formulaire pour la vue
        $form = $form->createView();

        // Transmission du formulaire ?? la vue
        return $this->render('product/update.html.twig', [
            'form' => $form,
            'product' => $product,
        ]);
    }

    /**
     * Supprimer la fiche d'un produit
     * /!\ dans le fichier config/packages/framework.yaml, modifier le parametre "http_method_override"
     * framework:
     *      http_method_override: true
     * url ex: /product
     * name: app_product_delete
     * 
     * @Route("/{id}/delete", name="delete", methods={"HEAD", "GET", "DELETE"})
     */
    public function delete(ManagerRegistry $doctrine, Product $product, Request $request): Response
    {// Condition
        if ($request->getMethod() == 'DELETE')
        {
            // G??n??rer le message de confirmation d'execution de la suppression
            $message = "Le produit <strong>". $product->getTitle() ."</strong> ?? ??t?? supprim??";

            // Suppression de la BDD
            $em = $doctrine->getManager();
            $em->remove( $product );
            $em->flush();

            // Ajout du message dans la session
            $this->addFlash('success', $message);

            // Redirection de l'utilisateur
            return $this->redirectToRoute('app_product_index');
        }

        // Affichage d'un message de confirmation de suppression
        return $this->render('product/delete.html.twig', [
            'product' => $product
        ]);
    }
}
