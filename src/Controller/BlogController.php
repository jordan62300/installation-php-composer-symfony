<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles,
        ]);
    }
    /**
 * @Route("/", name="home")
 */
public function home() {
    return $this->render('blog/home.html.twig',[
        'title' => 'Bienvenue mes amis',
        'age' => 17
    ]);
}

/**
* @Route("/blog/new", name="blog_create")
*/

public function create(Request $request,ObjectManager $manager) {
$article = new Article();
$form = $this->createFormBuilder($article)
             ->add('title')
             ->add('content')
             ->add('image')
             
             ->getForm();

        $form->handleRequest($request);

        dump($article);
return $this ->render('blog/create.html.twig',[
    'formArticle' => $form->createView()
]);
}

    /**
 * @Route("/blog/{id}", name="blog_show")
 */
public function show($id) {
    $repo = $this->getDoctrine()->getRepository(Article::class);
    $article = $repo->find($id);
    return $this->render('blog/show.html.twig', [
        'article' => $article,
    ]);
}


}
