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

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{

    /**
     * @Route("/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder,AuthenticationUtils $authenticationUtils ): Response
    {

            $user = $this->getUser();
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            
            if ($form->isSubmitted() && $form->isValid()) {

                $pass = $form->get('plainPassword')->getData();

                $encoder = $this->container->get('security.encoder_factory')->getEncoder($entity); //get encoder for hashing pwd later
                $tempPassword = $encoder->encodePassword($entity->getPassword(), $entity->getSalt()); 
                
                $hashedPassword = $pass->hashPassword($user, $pass);

                dump($hashedPassword);
                dd($request);

                    dump($this->getUser()->getPassword());
                    dump($request);

                    $encodedPassword = $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    );

                    
                    dd($encodedPassword); 


                    $user->setName($form->get('name')->getData());
                    $user->setEmail($form->get('email')->getData());

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();
                    $this->addFlash('success', 'Modification effectuée avec succès');
                    return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
                
            }

            return $this->renderForm('user/edit.html.twig', [
                'user' => $user,
                'form' => $form,
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
        if(in_array('ROLE_ADMIN', $this->getUser()->getRoles())){
            return $this->render('user/signet.html.twig', ['user' => $user,]);
        }

        else{
            $this->addFlash('error_bad_redirection_user', 'Cette page est malheuresement pas pour vous');
            return $this->redirectToRoute('article_index');
        }
        
    }
   
}
