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
}

?>