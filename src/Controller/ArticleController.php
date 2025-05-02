<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController {

	#[Route('/create-article', name: "create-article")]
	public function displayCreateArticle(Request $request) {

        if ($request->isMethod("POST")) {
            $title = $request->request->get('title');
            $description = $request->request->get('description');
            $content = $request->request->get('content');
            $image = $request->request->get('image');
    
            dump($title);
            dump($description);
            dump($content);
            dump($image);
            die;
            }

		return $this->render('create-article.html.twig');
	}

}

?>