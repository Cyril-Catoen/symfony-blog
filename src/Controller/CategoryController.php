<?php 

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryForm;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController {

    #[Route('/create-category', name: 'create-category')]
	public function createCategory(Request $request, EntityManagerInterface $entityManager) {

            // On créé une instance de category
            $category = new Category();
    
            // Après avoir créé le gabarit de formulaire "CategoryForm" généré avec "php bin/console make:form >> Category >> Category"
            // et l'instance de category, on génère le formulaire
            $categoryForm = $this->createForm(CategoryForm::class, $category);
    
            // La variable du formulaire stocke les données envoyées en POST
            $categoryForm->handleRequest($request);
    
            // S'il y a des données soumises en POST, alors elles sont enregistrées dans la base de données.
            if ($categoryForm->isSubmitted()) {
                // Les propriétés de la Category ont été automatiquement remplies 
                // par symfony et le système de formulaire
                $category->setCreatedAt(new \DateTime()); // créé une date automatique pour ne pas avoir à le remplir manuellement dans le formulaire
                $entityManager->persist($category);
                $entityManager->flush();
            }
    
            return $this->render('create-category.html.twig', [
                'categoryForm' => $categoryForm->createView()
            ]);
    
        }
    
    #[Route('/list-category', name: 'list-category')]
	public function displayListcategories(categoryRepository $categoryRepository) {

		// permet de faire une requête SQL SELECT * sur la table category
		$categories = $categoryRepository->findAll();

		return $this->render('list-category.html.twig', [
			'categorys' => $categories
		]);
		
	}

    #[Route('/single-category/{id}', name: 'single-category')]
	public function displaySinglecategories($id, categoryRepository $categoryRepository) {

		// permet de faire une requête SQL SELECT * sur la table category et de sélectionner un item par ID
		$category = $categoryRepository->find($id);

		// Si l'id demandé ne correspond à aucun category
		// Alors l'utilisateur est redirigé vers une page d'erreur 404.
		// Sinon l'category avec l'id correspond est affiché.
		if (!$category) {
			return $this->redirectToRoute('404');
		}
		return $this->render('single-category.html.twig', [
			'category' => $category
		]);
	}


	}

?>