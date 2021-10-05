<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Form\UserRoleAdminType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_gestion_user_article")
     */
    public function index_user_article(UserRepository $userRepository, ArticleRepository $articleRepository): Response
    {
        return $this->render('admin/index_user_article.html.twig', [
            'users' => $userRepository->findAll(), 'articles' => $articleRepository->findAllWithReport(),
        ]);
    }

    /**
     * @Route("/{id}/user/role", name="user_role", methods={"GET","POST"})
     */
    public function gestion_user_role(Request $request, User $user): Response
    {

        $form = $this->createForm(UserRoleAdminType::class, $user);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/role_user.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

}
