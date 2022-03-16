<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * @Route("/category", name="app_category_")
 * 
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("s", name="index")
     */
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
        ]);
    }

    /**
     * Ajouter une categorie dans la bdd
     * 
     * url ex: /category
     * name: app_category_create
     * 
     * @Route("", name="create")
     */
    public function create(ManagerRegistry $doctrine, Request $request, ValidatorInterface $validator): Response
    {
        $errors = [];

        // Create Form
        // --

        // Initialiser la categorie
        $category = new Category;

        // Construction du formulaire
        $form = $this->createForm(CategoryType::class, $category);

        // Handle the request
        $form->handleRequest($request);

        // Catch form submission
        if ( $form->isSubmitted() ) 
        {
            // recuperer les donnees en tableau
            $submittedToken = $request->request->get('category')['_csrf_category_token'];            
            if (!$this->isCsrfTokenValid('_csrf_category_token_id', $submittedToken))
            {
                dd("Erreur de Token");
            }
            
            // Handle form errors
            $errors = $validator->validate( $category );

            // si le form est valid
            if ( $form->isValid() )
            {
                // enregistrement en bdd
                $en = $doctrine->getManager();
                $en->persist( $category );
                $en->flush();

                // rediriger utilisateur
                return $this->redirectToRoute('app_category_index');
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
     * Afficher le detail d'une categorie'
     * 
     * url ex: /category
     * name: app_category_read
     * 
     * @Route("/{id}", name="read")
     */
    public function read(int $id): Response
    {

    }

    /**
     * Modifier la fiche d'une categorie
     * 
     * url ex: /category
     * name: app_category_update
     * 
     * @Route("/{id}/edit", name="update")
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
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(int $id): Response
    {

    }

}
