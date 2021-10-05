<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


//return new JsonRezsponse(["sucess" => true]);
/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }
    
    /**
     * @Route("/ArticleUser", name="article_user", methods={"GET"})
     */
    public function indexArticleUser(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/user.html.twig', [
            'articles' => $articleRepository->findAllWithUserId($this->getUser()->getId()),
        ]);
    }



    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // dd($form->get('picture')->getData());
            $brochureFile = $form->get('picture')->getData();
            if ($brochureFile)
            {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                try 
                {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } 
                catch (FileException $e) 
                {
                    // ... handle exception if something happens during file upload
                }
                $article->setPicture($newFilename);
            }

            $article->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'Votre article a bien été créé');
            return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {

        if($this->getUser()->getId() == $article->getUser()->getId()){
           $form = $this->createForm(ArticleType::class, $article);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'Votre article a bien été édité');
                return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
            }

            //pas besoin de message 
            return $this->renderForm('article/edit.html.twig', [
                'article' => $article,
                'form' => $form,
            ]);
        }
        else{  
            $this->addFlash('error_bad_redirection_user', 'Cette page est malheuresement pas pour vous');
            return $this->redirectToRoute('article_index');
        }
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"POST"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Votre article a bien été supprimé');
        return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
    }
}
