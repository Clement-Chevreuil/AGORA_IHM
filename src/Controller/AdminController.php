<?php

namespace App\Controller;

use App\Entity\Support;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\SupportRepository;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Form\SupportType;
use App\Form\UserRoleAdminType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Monolog\DateTimeImmutable;
use App\Entity\ArchiveUser;


/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_gestion_user_article")
     */
    public function index_user_article(UserRepository $userRepository, ArticleRepository $articleRepository, SupportRepository $supportRepository): Response
    {
        return $this->render('admin/index_user_article.html.twig', [
            'users' => $userRepository->findAll(), 'articles' => $articleRepository->findAllWithReport(), 'supports' => $supportRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{idUser}/change/role", name="user_change_role", options={"expose"=true}, methods={"GET","POST"})
     */
    public function changeAdmin(UserRepository $userRepository, $idUser): Response
    {
        $user = new User();
        $user = $userRepository->find($idUser);
        //ajouter verification admin stp
        if ((in_array("ROLE_ADMIN", $this->getUser()->getRoles()) && !in_array("ROLE_ADMIN", $user->getRoles())) || (in_array("ROLE_SUPER_ADMIN",  $this->getUser()->getRoles()) && !in_array("ROLE_SUPER_ADMIN", $user->getRoles()))) {


            if (in_array('ROLE_ADMIN', $user->getRoles())) {


                $tab = $user->getRoles();
                if (($key = array_search('ROLE_ADMIN',  $user->getRoles())) !== false) {
                    unset($tab[$key]);
                }
                $user->setRoles(array_values($tab));

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                return new Response("success_uncheck");
            } else {

                $tab = $user->getRoles();
                array_push($tab, "ROLE_ADMIN");
                $user->setRoles(array_values($tab));

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                return new Response("success_check");
            }
        } else {
            return new Response("action_interdite");
        }
    }

    /**
     * @Route("/{idUser}/change/blocked", name="user_change_blocked", options={"expose"=true}, methods={"GET","POST"})
     */
    public function changeBlocked(UserRepository $userRepository, $idUser): Response
    {


        $user = new User();
        $user = $userRepository->find($idUser);
        if ((in_array("ROLE_ADMIN", $this->getUser()->getRoles()) && !in_array("ROLE_ADMIN", $user->getRoles())) || (in_array("ROLE_SUPER_ADMIN",  $this->getUser()->getRoles()) && !in_array("ROLE_SUPER_ADMIN", $user->getRoles()))) {
            if ($user->getBlocked() == false) {

                $user->setBlocked(true);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                //dd($user);
                return new Response("success_blocked");
            } else {

                $user->setBlocked(false);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                //dd($user);
                return new Response("success_unblocked");
            }
        } else {
            return new Response("action_interdite");
        }
    }

    /**
     * @Route("/{idSupport}/{value}/change/status", name="change_status", options={"expose"=true}, methods={"GET","POST"})
     */
    public function changeStatus(SupportRepository $supportRepository, $idSupport, $value): Response
    {

        if ($value != "EnAttente" && $value != "EnCours" && $value != "Resolu" && $value != "Abandon") {
            return new Response("error");
        } else {
            $support = new Support();
            $support = $supportRepository->find($idSupport);
            $support->setStatus($value);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($support);
            $entityManager->flush();
            //dd($support);
            return new Response("success");
        }
    }

    /**
     * @Route("/{id}/delete/user", name="user_delete_admin", methods={"POST"})
     */
    public function deleteUser(Request $request, User $user): Response
    {
        if ((in_array("ROLE_ADMIN", $this->getUser()->getRoles()) && !in_array("ROLE_ADMIN", $user->getRoles())) || (in_array("ROLE_SUPER_ADMIN",  $this->getUser()->getRoles()) && !in_array("ROLE_SUPER_ADMIN", $user->getRoles()))) {
            if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
                $date = new \DateTimeImmutable();
                $archiveUser = new ArchiveUser();
                $archiveUser->setEmail($user->getEmail());
                $archiveUser->setRoles($user->getRoles());
                $archiveUser->setPassword($user->getPassword());
                $archiveUser->setName($user->getName());
                $archiveUser->setBlocked($user->getBlocked());
                $archiveUser->setSuppressedAt($date);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($user);
                $entityManager->persist($archiveUser);
                $entityManager->flush();
            }

            $this->addFlash('success', 'Utilisateur supprim??');
            return $this->redirectToRoute('admin_gestion_user_article', [], Response::HTTP_SEE_OTHER);
        } else {
            $this->addFlash('error', 'Action interdite');
            return $this->redirectToRoute('admin_gestion_user_article', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/delete/article", name="article_delete_admin", methods={"POST"})
     */
    public function deleteArticle(Request $request, Article $article): Response
    {
        if ((in_array("ROLE_ADMIN", $this->getUser()->getRoles()) && !in_array("ROLE_ADMIN", $user->getRoles())) || (in_array("ROLE_SUPER_ADMIN",  $this->getUser()->getRoles()) && !in_array("ROLE_SUPER_ADMIN", $user->getRoles()))) {
            if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($article);
                $entityManager->flush();
            }

            $this->addFlash('success', 'Votre article a bien ??t?? supprim??');
            return $this->redirectToRoute('admin_gestion_user_article', [], Response::HTTP_SEE_OTHER);
        } else {

            $this->addFlash('error', 'Action interdite');
            return $this->redirectToRoute('admin_gestion_user_article', [], Response::HTTP_SEE_OTHER);
        }
    }
}
