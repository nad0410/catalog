<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * @Route("/categor", name="app_category_")
 * 
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("ies", name="index", methods={"HEAD", "GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {

        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * Ajouter une categorie dans la bdd
     * 
     * url ex: /category
     * name: app_category_create
     * 
     * @Route("y", name="create", methods={"HEAD", "GET", "POST"})
     */
    public function create(ManagerRegistry $doctrine, Request $request, ValidatorInterface $validator): Response
    {
        $errors = [];

        // Create Form
        // --

        // Initialiser l'entité
        $category = new Category;

        // Construction du formulaire
        $form = $this->createForm(CategoryType::class, $category);

        // récuperation de la requete HTTP
        $form->handleRequest($request);

        // Test la soumission du formulaire
        if ( $form->isSubmitted() ) 
        {

            $csrf_token = $request->request->get( $form->getName() ){'_csrf_category_token'};
            // recuperation du Token(CSRF Token)
            //  $submittedToken = $request->request->get('category')['_csrf_category_token'];

            // verifier l'integrité du formulaire (CSRF Token)           
            if ( ! $this->isCsrfTokenValid('_csrf_category_token_id', $csrf_token))
            {
                throw new \Exception("Erreur de Token");
            }
            
            // validation du formulaire
            $validator->validate( $category );

            // si le form est valid
            if ( $form->isValid() )
            {
                
                // ajouter des valeurs par defaut

                // enregistrement en bdd
                $en = $doctrine->getManager();
                $en->persist( $category );
                $en->flush();

                // rediriger utilisateur vers la page detail de la categorie
                return $this->redirectToRoute('app_category_read', [
                    'id' => $category->getId()
                ]);
            }
        }

        // Préparation du formulaire pour la vue
        $form = $form->createView();

        // Response HTTP
        // --
        return $this->render('category/create.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * lire le detail d'une categorie'
     * 
     * url ex: /category
     * name: app_category_read
     * 
     * @Route("y/{id}", name="read", methods={"HEAD", "GET"})
     */
    public function read(Category $category): Response
    {
        
        return $this->render('category/read.html.twig', [
           'category' => $category
        ]);

    }

    /**
     * Modifier la fiche d'une categorie
     * 
     * url ex: /category
     * name: app_category_update
     * 
     * @Route("y/{id}/edit", name="update", methods={"HEAD", "GET", "POST"})
     */
    public function update(Category $category, ManagerRegistry $doctrine, Request $request, ValidatorInterface $validator): Response
    {
        // Construction du formulaire
        $form = $this->createForm(CategoryType::class, $category);
    
        // Récupération de la requete HTTP
        $form->handleRequest($request);
    
        // Test la soumission du formulaire
        if ($form->isSubmitted())
        {
            // Récupération du CSRF Token
            $csrf_token = $request->request->get( $form->getName() )['_csrf_category_token'];
    
            // Vérifier l'intégrité du formulaire (CSRF Token)
            if ( ! $this->isCsrfTokenValid('_csrf_category_token_id', $csrf_token) )
            {
                    throw new \Exception("Erreur de token");
            }
                
            // Validation du formulaire
            $validator->validate( $category );
    
            if ($form->isValid())
            {
                // Ajouter des valeurs par défaut
    
                // Enregistrement des données en BDD
                $em = $doctrine->getManager();
                $em->persist( $category );
                $em->flush();
    
                // Redirection de l'utilisateur vers la page du détail de la catégorie
                return $this->redirectToRoute('app_category_read', [
                    'id' => $category->getId()
                ]);
            }
        }
    
        // Préparation du formulaire pour la vue
        $form = $form->createView();
    
        // Transmission du formulaire à la vue
        return $this->render('category/update.html.twig', [
            'form' => $form
        ]);
    }
    

    /**
     * Supprimer la fiche d'une categorie
     * 
     * url ex: /category
     * name: app_category_delete
     * 
     * @Route("y/{id}/delete", name="delete", methods={"HEAD", "GET", "DELETE"})
     */
    public function delete(ManagerRegistry $doctrine, Category $category, Request $request): Response
    {
        // condition
        if ($request->getMethod() == 'DELETE')
        {
            // generer le message de confirmation de suppression
            $message = "La categorie <strong>". $category->getName() ."</strong> à été supprimé.";

            // supprimer de la BDD
            $en = $doctrine->getManager();
            $en->remove( $category );
            $en->flush();

            // creation d'un message
            $this->addFlash('success', $message);

            // redirection de l'utilisateur
            return $this->redirectToRoute('app_category_index');

         
        }

       // afficher message de confirmation
       return $this->render('category/delete.html.twig', [
           'category' => $category
       ]); 

    }

}
