<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController {

	#[Route('/create-article', name: "create-article")]
	public function displayCreateArticle() {
		return $this->render('create-article.html.twig');
	}

}

?>