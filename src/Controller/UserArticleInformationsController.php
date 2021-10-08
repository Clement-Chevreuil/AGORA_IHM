<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Entity\UserArticleInformations;
use App\Repository\ArticleRepository;


use App\Repository\UserArticleInformationsRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserArticleInformationsController extends AbstractController
{
    /**
     * @Route("/user/article/informations/{idArticle}/like", options={"expose"=true}, name="create_like")
     */
    public function liker(UserArticleInformationsRepository $informationsRep, ArticleRepository $articleRepository, $idArticle): Response
    {

        $article = new Article();
        $article = $articleRepository->find($idArticle);

        $infos = $informationsRep->findUserArticleInformations($this->getUser()->getId(), $article->getId());
        

        if($infos == []){

            $informations = new UserArticleInformations();
            $informations->setArticle($article);
            $informations->setLiker(true);
            $informations->setreport(false);
            $informations->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($informations);
            $entityManager->flush(); 
        }
        else{
            if($infos[0]->getLiker() == true){
                if($infos[0]->getReport() == false){
                    
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($infos[0]);
                    $entityManager->flush();
                    
                }
                else{
                   $infos[0]->setLiker(false); 
                }
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($infos[0]);
                $entityManager->flush();    
                return new Response("success_delete");
            }
            else{
                $infos[0]->setLiker(true);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($infos[0]);
                $entityManager->flush(); 
            }
                
        }

        return new Response("success_like");
    }

    /**
     * @Route("/user/article/{idArticle}/lost/like", name="lost_like", methods={"POST"})
     */
    public function remove_liker(UserArticleInformationsRepository $informationsRep, ArticleRepository $articleRepository, $idArticle): Response
    {

        $article = new Article();
        $article = $articleRepository->find($idArticle);

        dump($article);

        $infos = $informationsRep->findUserArticleInformations($this->getUser()->getId(), $article->getId());
        dump($infos);

        if($infos[0]->getReport() == false){
            // dd("hey");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($infos[0]);
            $entityManager->flush();
            
        }
        else{
            dump("hey1");
            $infos[0]->setLiker(false); 
            // dd($infos[0]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($infos[0]);
            $entityManager->flush();    
        }       

        $this->addFlash('success', 'Article enlever de vos favoris');
        return $this->render('user/show.html.twig', ['user' => $this->getUser(),]);
        
    }

    /**
     * @Route("/user/article/informations/{idArticle}/report",options={"expose"=true}, name="create_report")
     */
    public function report(UserArticleInformationsRepository $informationsRep, ArticleRepository $articleRepository, $idArticle): Response
    {

        $article = new Article();
        $article = $articleRepository->find($idArticle);

        $infos = $informationsRep->findUserArticleInformations($this->getUser()->getId(), $article->getId());
        
        if($infos == []){
            $informations = new UserArticleInformations();
            $informations->setArticle($article);
            $informations->setLiker(false);
            $informations->setreport(true);
            $informations->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($informations);
            $entityManager->flush(); 
        }
        else{
            if($infos[0]->getReport() == true){
                return new Response("error_impossible");
            }
            else{
                $infos[0]->setReport(true);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($infos[0]);
            $entityManager->flush();     
        }

        return new Response("success_report");
    }


    
}
