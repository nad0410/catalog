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
     * @Route("ies", name="index")
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
     * @Route("y", name="create")
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
     * @Route("y/{id}", name="read")
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
     * @Route("y/{id}/edit", name="update")
     */
    public function update(int $id): Response
    {
        
    }

    /**
     * Supprimer la fiche d'une categorie
     * 
     * url ex: /category
     * name: app_category_delete
     * 
     * @Route("y/{id}/delete", name="delete")
     */
    public function delete(int $id): Response
    {

    }

}
