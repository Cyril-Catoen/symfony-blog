<?php 

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController {

    #[Route('/list-category', name: 'list-category')]
	public function displayListcategorys(categoryRepository $categoryRepository) {

		// permet de faire une requête SQL SELECT * sur la table category
		$categories = $categoryRepository->findAll();

		return $this->render('list-category.html.twig', [
			'categorys' => $categories
		]);
		
	}

    #[Route('/single-category/{id}', name: 'single-category')]
	public function displaySinglecategorys($id, categoryRepository $categoryRepository) {

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