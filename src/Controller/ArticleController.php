<?php 

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController {

	#[Route('/create-article', name: "create-article")]
	public function displayCreateArticle(Request $request, EntityManagerInterface $entityManager)  {

        if ($request->isMethod("POST")) {
            $title = $request->request->get('title');
            $description = $request->request->get('description');
            $content = $request->request->get('content');
            $image = $request->request->get('image');
    
            $article = new Article($title, $description, $content, $image);

            $entityManager->persist($article); // permet d'enregistrer dans la base de données l'article créé
			$entityManager->flush();

            // $this->addFlash("success", "Article : ". $article->title ." enregistré");;
            }

		return $this->render('create-article.html.twig');
	}

    #[Route('/list-article', name: 'list-article')]
	public function displayListArticles(ArticleRepository $articleRepository) {

		// permet de faire une requête SQL SELECT * sur la table article
		$articles = $articleRepository->findAll();

		return $this->render('list-article.html.twig', [
			'articles' => $articles
		]);
		
	}

    #[Route('/single-article/{id}', name: 'single-article')]
	public function displaySingleArticles($id, ArticleRepository $articleRepository) {

		// permet de faire une requête SQL SELECT * sur la table article et de sélectionner un item par ID
		$article = $articleRepository->find($id);

		// Si l'id demandé ne correspond à aucun article
		// Alors l'utilisateur est redirigé vers une page d'erreur 404.
		// Sinon l'article avec l'id correspond est affiché.
		if (!$article) {
			return $this->redirectToRoute('404');
		}
		return $this->render('single-article.html.twig', [
			'article' => $article
		]);
	}

	#[Route('/delete-article/{id}', name: "delete-article")]
	public function deleteArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager) 
		{
			// On cible l'article à supprimer par son id unique.
			$article = $articleRepository->find($id);
	
			// On utilise la méthode remove de la classe EntityManager 
			// On prend en paramètre l'article à supprimer
			$entityManager->remove($article);
			$entityManager->flush();
	
			// On ajoute un message flash pour notifier que l'article est supprimé
			$this->addFlash('success', 'The article has been deleted');
	
			// On redirige vers la page de liste mis à jour
			return $this->redirectToRoute('list-article');
		}	

		#[Route('/update-article/{id}', name: "update-article")]
		public function updateArticle($id, Request $request, ArticleRepository $articleRepository, EntityManagerInterface $entityManager) {
			$article = $articleRepository->find($id);
		
			if (!$article) {
				$this->addFlash('error', 'Article non trouvé.');
				return $this->redirectToRoute('list-article');
			}
		
			if ($request->isMethod("POST")) { // On récupère les nouvelles données si le formulaire est soumis.
				
				// Méthode 1 : set
				// $article->setTitle($request->request->get('title'));
				// $article->setDescription($request->request->get('description'));
				// $article->setContent($request->request->get('content'));
				// $article->setImage($request->request->get('image'));
		
				// $entityManager->flush(); // Enregistre la modification des données

				//Méthode 2 : fonction update créé dans Entity

				$title = $request->request->get('title');
				$description = $request->request->get('description');
				$content = $request->request->get('content');
				$image = $request->request->get('image');
    
           	 	$article->update($title, $description, $content, $image);

            	$entityManager->persist($article); // Enregistre dans la base de données l'article créé
				$entityManager->flush();
		
				$this->addFlash('success', 'Article mis à jour avec succès.');
		
				return $this->redirectToRoute('list-article');
			}
		
			return $this->render('update-article.html.twig', ['article' => $article]);
		}
	}

?>