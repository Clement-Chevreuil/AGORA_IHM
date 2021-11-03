<?php

namespace App\Controller;

use App\Entity\ArchiveUser;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Monolog\DateTimeImmutable;
use Symfony\Component\PasswordHasher\Hasher\CheckPasswordLengthTrait;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{

    /**
     * @Route("/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder,AuthenticationUtils $authenticationUtils, SluggerInterface $slugger ): Response
    {

            $user = $this->getUser();
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            
            if ($form->isSubmitted() && $form->isValid()) {

                $pass = $form->get('plainPassword')->getData();
                $this->passwordEncoder = $passwordEncoder;
                
                if($this->passwordEncoder->isPasswordValid($user, $pass)){

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
                        $user->setPicture($newFilename);
                        
                    }

                    $user->setName($form->get('name')->getData());
                    $user->setEmail($form->get('email')->getData());

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();
                    $this->addFlash('success', 'Modification effectuée avec succès');
                    return $this->render('user/show.html.twig', ['user' => $this->getUser()]);
                }
                else{
                    $this->addFlash('error', 'Le mot de passe est incorect');
                    return $this->renderForm('user/edit.html.twig', [
                        'user' => $user,
                        'form' => $form,
                    ]);
                }
                    
            }

            return $this->renderForm('user/edit.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);
    }

    /**
     * @Route("/show/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/search/{userName}", name="search_user", options={"expose"=true}, methods={"GET", "POST"})
     */
    public function search(UserRepository $userRepository, $userName): Response
    {
        
        $listUser = $userRepository->findUserByName($userName);
        $listUserSimp = array_column($listUser, 'name');
        return new JsonResponse($listUserSimp);
    }

    /**
     * @Route("/profil", name="user_profil", methods={"GET"})
     */
    public function profil(): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {

            $date = new \DateTimeImmutable();
            $archiveUser = new ArchiveUser();
            $archiveUser->setEmail($user->getEmail());
            $archiveUser->setRoles($user->getRoles());
            $archiveUser->setPassword($user->getPassword());
            $archiveUser->setName($user->getName());
            $archiveUser->setBlocked($user->getBlocked());
            $archiveUser->setCreatedAt($user->getCreatedAt());
            $archiveUser->setUpdatedAt($user->getUpdatedAt());
            $archiveUser->setSuppressedAt($date);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->persist($archiveUser);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Utilisateur supprimé');
        return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
    }

        /**
     * @Route("/signet", name="user_signet", methods={"GET"})
     */
    public function signet(): Response
    {
        $user = $this->getUser();

        return $this->render('user/signet.html.twig', ['user' => $user,]);
        
    }

    /**
     * @Route("/change/theme", name="user_change_theme", options={"expose"=true}, methods={"GET","POST"})
     */
    public function changeTheme(UserRepository $userRepository): Response
    {
        $user = $this->getUser();

        if($user->getThemeSombre() == false){

            $user->setThemeSombre(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        
            //dd($user);
            return new Response("success_theme_sombre");

        }
        else{

            $user->setThemeSombre(false);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            //dd($user);
            return new Response("success_theme_claire");
        }

    }
   
}
