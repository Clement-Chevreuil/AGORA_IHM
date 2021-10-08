<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {

        if($this->getUser()->getId() == $user->getId() || in_array('ROLE_ADMIN', $this->getUser()->getRoles())){
            return $this->render('user/show.html.twig', ['user' => $user,]);
            
        }

        else{
            $this->addFlash('error_bad_redirection_user', 'Cette page est malheuresement pas pour vous');
            return $this->redirectToRoute('article_index');
        }
        
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder,AuthenticationUtils $authenticationUtils ): Response
    {
        if($this->getUser()->getId() == $user->getId()){


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

        else{
            $this->addFlash('error_bad_redirection_user', 'Cette page est malheuresement pas pour vous');
            return $this->redirectToRoute('article_index');
        }
        
        
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Utilisateur supprimé');
        return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
    }
   
}
